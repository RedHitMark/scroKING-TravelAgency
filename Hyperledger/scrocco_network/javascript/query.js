const FabricCAServices = require('fabric-ca-client');
const { FileSystemWallet, X509WalletMixin, Gateway } = require('fabric-network');

const path = require('path');
const fs = require('fs');

const util = require('./../../utils');


const ccpPath = path.resolve(__dirname, '..', '..', 'first-network', 'connection-org1.json');
const ccpJSON = fs.readFileSync(ccpPath, 'utf8');
const ccp = JSON.parse(ccpJSON);


module.exports = {
    init : async function() {
        await enrollAdmin();
    },

    ricarica : async function(userID, money, description) {
        const transactionNumber = await getNewTransactionID();
        const transactionID = "CAR" + transactionNumber;
        const timestamp = util.getTimestamp();

        console.log("Transazione n." + transactionID);

        writeTransaction(transactionID, userID, money, description, timestamp.toString());
    },

    prenotazioneViaggio : async function(userID, money, description) {
        const transactionNumber = await getNewTransactionID();
        const transactionID = "CAR" + transactionNumber;
        const timestamp = util.getTimestamp();

        money = (parseInt(money) * (-1)).toString();

        console.log("Transazione n." + transactionID);

        writeTransaction(transactionID, userID, money, description, timestamp.toString());
    },

    getWallet : async function(userID) {
        let result = await readTransaction(userID);

        let wallet = 0;
        let transactions = [];
        result.forEach( (transaction) => {
            if(transaction.user_id === userID) {
                wallet += parseInt(transaction.money);
                transactions.push(transaction);
            }
        });

        return {
            wallet: wallet,
            transactions: transactions
        };
    },

    readAll : async function() {
        return await readTransaction(SCROCCO_USER_NAME);
    }
};



async function readTransaction(userID) {
    //get contract and gateway form hyperledger network
    let hyperledgerObj = await getHyperLedgerObj(userID);
    let contract = hyperledgerObj.contract;
    let gateway = hyperledgerObj.gateway;

    // Evaluate the specified  transaction.
    let result = await contract.evaluateTransaction(READ_TRANSACTION);


    let obj_response = JSON.parse(result.toString());


    obj_response = obj_response.filter( (value) => {
        return value.Key !== "CAR0" && value.Key !== "CAR1" && value.Key !== "CAR2" && value.Key !== "CAR3" && value.Key !== "CAR4" && value.Key !== "CAR5" && value.Key !== "CAR6" && value.Key !== "CAR7" && value.Key !== "CAR8" && value.Key !== "CAR9";
    });

    let json_response = [];
    obj_response.forEach( (obj) => {
        let element = {
            transaction_id : obj.Key.substring(3),
            user_id : obj.Record.make,
            money : obj.Record.model,
            description : obj.Record.color,
            timestamp : obj.Record.owner
        };
        json_response.push(element);
    });

    return json_response;
}

async function writeTransaction(transaction_id, user_id, money, description, timestamp) {
    //get contract and gateway form hyperledger network
    let hyperledgerObj = await getHyperLedgerObj();
    let contract = hyperledgerObj.contract;
    let gateway = hyperledgerObj.gateway;

    // Submit the specified  transaction.
    await contract.submitTransaction(WRITE_TRANSACTION, transaction_id, user_id, money, description, timestamp);

    await gateway.disconnect();
}

async function getNewTransactionID() {
    const result = await readTransaction();

    let max = 9;
    result.forEach( (transaction) => {
        if( parseInt(transaction.transaction_id) > max) {
            max = parseInt(transaction.transaction_id);
        }
    });

    return max + 1;
}

async function getHyperLedgerObj(userID) {
    // Create a new file system based wallet for managing identities.
    const walletPath = path.join(process.cwd(), '/scrocco_network/javascript/wallet');
    const wallet = new FileSystemWallet(walletPath);
    console.log(walletPath);

    // Check to see if we've already enrolled the user.
    const userExists = await wallet.exists(userID);
    if (!userExists) {
        registerUser(userID);
        throw new Error("An identity for the user " + userID +" does not exist in the wallet");
    }

    // Create a new gateway for connecting to our peer node.
    const gateway = new Gateway();
    await gateway.connect(ccpPath, { wallet, identity: userID, discovery: { enabled: true, asLocalhost: true } });

    // Get the network (channel) our contract is deployed to.
    const network = await gateway.getNetwork(CHANNEL_NAME);

    // return contract from the network.
    return {
        contract : await network.getContract(CONTRACT_NAME),
        gateway : gateway
    };
}

async function enrollAdmin() {
    // Create a new CA client for interacting with the CA.
    const caInfo = ccp.certificateAuthorities['ca.org1.example.com'];
    const caTLSCACerts = caInfo.tlsCACerts.pem;
    const ca = new FabricCAServices(caInfo.url, { trustedRoots: caTLSCACerts, verify: false }, caInfo.caName);

    // Create a new file system based wallet for managing identities.
    const walletPath = path.join(process.cwd(), '/scrocco_network/javascript/wallet');
    const wallet = new FileSystemWallet(walletPath);

    // Check to see if we've already enrolled the admin user.
    const adminExists = await wallet.exists(ADMIN_NAME);
    if ( !adminExists) {
        // Enroll the admin user, and import the new identity into the wallet.
        const enrollment = await ca.enroll({ enrollmentID: ADMIN_NAME, enrollmentSecret: ADMIN_PASSWORD });
        const identity = X509WalletMixin.createIdentity('Org1MSP', enrollment.certificate, enrollment.key.toBytes());
        await wallet.import(ADMIN_NAME, identity);

        console.log('Successfully enrolled admin user "admin" and imported it into the wallet');
    }
}

async function registerUser(userID) {
    // Create a new file system based wallet for managing identities.
    const walletPath = path.join(process.cwd(), '/scrocco_network/javascript/wallet');
    const wallet = new FileSystemWallet(walletPath);

    // Check to see if we've already enrolled the user.
    const userExists = await wallet.exists(userID);
    if (!userExists) {
        // Check to see if we've already enrolled the admin user.
        const adminExists = await wallet.exists(ADMIN_NAME);
        if (!adminExists) {
            await enrollAdmin();
        }

        // Create a new gateway for connecting to our peer node.
        const gateway = new Gateway();
        await gateway.connect(ccpPath, { wallet, identity: ADMIN_NAME, discovery: { enabled: true, asLocalhost: true } });

        // Get the CA client object from the gateway for interacting with the CA.
        const ca = gateway.getClient().getCertificateAuthority();
        const adminIdentity = gateway.getCurrentIdentity();

        // Register the user, enroll the user, and import the new identity into the wallet.
        const secret = await ca.register({ affiliation: 'org1.department1', enrollmentID: userID, role: 'client' }, adminIdentity);
        const enrollment = await ca.enroll({ enrollmentID: userID, enrollmentSecret: secret });
        const userIdentity = X509WalletMixin.createIdentity('Org1MSP', enrollment.certificate, enrollment.key.toBytes());
        await wallet.import(userID, userIdentity);
        console.log('Successfully registered and enrolled ' + userID + ' and imported it into the wallet');
    }
}

const ADMIN_NAME = 'admin';
const ADMIN_PASSWORD = 'adminpw';
const SCROCCO_USER_NAME = 'scrocco-user';
const CHANNEL_NAME = 'mychannel';
const CONTRACT_NAME = 'fabcar';
const READ_TRANSACTION = 'queryAllCars';
const WRITE_TRANSACTION = 'createCar';

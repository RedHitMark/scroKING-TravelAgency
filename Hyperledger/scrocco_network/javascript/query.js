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
        await registerScroccoUser();
    },

    ricarica : async function(userID, money, description) {
        const transactionID = "CAR" + (getLastTransactionID() + 1);
        const timestamp = util.getTimestamp();

        writeTransaction(transactionID, userID, money, description, timestamp);
    },

    prenotazioneViaggio : async function(userID, money, description) {
        const transactionID = "CAR" + (await getLastTransactionID() + 1);
        const timestamp = util.getTimestamp();

        money = (parseInt(money) * (-1)).toString();

        writeTransaction(transactionID, userID, money, description, timestamp);
    },

    getWallet : async function(userID) {
        let result = readTransaction();

        let wallet = 0;
        let transactions = [];
        result.forEach( (transaction) => {
            if(transaction.user_id === userID) {
                wallet += transaction.money;
                transactions.push(transaction);
            }
        });

        return {
            wallet: wallet,
            transactions: transactions
        };
    },

    readAll : async function() {
        return await readTransaction();
    }
};

const ADMIN_NAME = 'admin';
const ADMIN_PASSWORD = 'adminpw';
const SCROCCO_USER_NAME = 'scrocco-user';
const CHANNEL_NAME = 'mychannel';
const CONTRACT_NAME = 'fabcar';
const READ_TRANSACTION = 'queryAllCars';
const WRITE_TRANSACTION = 'createCar';

async function readTransaction() {
    //get contract form hyperledger network
    let contract = await getHyperLedgerContract();

    // Evaluate the specified  transaction.
    let result = await contract.evaluateTransaction(READ_TRANSACTION);


    let obj_response = JSON.parse(result.toString());


    obj_response = obj_response.filter( (value) => {
        return value.Key !== "CAR0" && value.Key !== "CAR1" && value.Key !== "CAR2" && value.Key !== "CAR3" && value.Key !== "CAR4" && value.Key !== "CAR5" && value.Key !== "CAR6" && value.Key !== "CAR7" && value.Key !== "CAR8" && value.Key !== "CAR9";
    });

    let json_response = [];
    obj_response.forEach( (obj) => {
        let element = {
            transaction_id : obj.Key,
            user_id : obj.Record.owner,
            money : obj.Record.make,
            description : obj.Record.owner,
            timestamp : obj.Record.model
        };
        json_response.push(element);
    });

    return json_response;
}

async function writeTransaction(transaction_id, user_id, money, description, timestamp) {
    //get contract form hyperledger network
    let contract = await getHyperLedgerContract();

    // Evaluate the specified  transaction.
    return await contract.evaluateTransaction(WRITE_TRANSACTION, transaction_id, user_id, money, description, timestamp);
}

async function getLastTransactionID() {
    const result = await readTransaction();

    let max = 10;
    result.forEach( (transaction) => {
        if( parseInt(transaction.transaction_id.substring(3)) > max) {
            max = parseInt(transaction.transaction_id.substring(3));
        }
    });

    return max;
}

async function getHyperLedgerContract() {
    // Create a new file system based wallet for managing identities.
    const walletPath = path.join(process.cwd(), '/scrocco_network/javascript/wallet');
    const wallet = new FileSystemWallet(walletPath);
    console.log(walletPath);

    // Check to see if we've already enrolled the user.
    const userExists = await wallet.exists(SCROCCO_USER_NAME);
    if (!userExists) {
        //Run the registerUser.js application before retrying
        //Or check working directory
        throw new Error("An identity for the user " + SCROCCO_USER_NAME +" does not exist in the wallet");
    }

    // Create a new gateway for connecting to our peer node.
    const gateway = new Gateway();
    await gateway.connect(ccpPath, { wallet, identity: SCROCCO_USER_NAME, discovery: { enabled: true, asLocalhost: true } });

    // Get the network (channel) our contract is deployed to.
    const network = await gateway.getNetwork(CHANNEL_NAME);

    // return contract from the network.
    return network.getContract(CONTRACT_NAME);
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

async function registerScroccoUser() {
    // Create a new file system based wallet for managing identities.
    const walletPath = path.join(process.cwd(), '/scrocco_network/javascript/wallet');
    const wallet = new FileSystemWallet(walletPath);

    // Check to see if we've already enrolled the user.
    const userExists = await wallet.exists(SCROCCO_USER_NAME);
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
        const secret = await ca.register({ affiliation: 'org1.department1', enrollmentID: SCROCCO_USER_NAME, role: 'client' }, adminIdentity);
        const enrollment = await ca.enroll({ enrollmentID: SCROCCO_USER_NAME, enrollmentSecret: secret });
        const userIdentity = X509WalletMixin.createIdentity('Org1MSP', enrollment.certificate, enrollment.key.toBytes());
        await wallet.import(SCROCCO_USER_NAME, userIdentity);
        console.log('Successfully registered and enrolled ' + SCROCCO_USER_NAME + ' and imported it into the wallet');
    }
}

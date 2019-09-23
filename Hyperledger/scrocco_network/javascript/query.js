const { FileSystemWallet, Gateway } = require('fabric-network');
const path = require('path');

const ccpPath = path.resolve(__dirname, '..', '..', 'first-network', 'connection-org1.json');

const USER_NAME = 'scrocco-user';
const CHANNEL_NAME = "mychannel";
const CONTRACT_NAME = "fabcar";
const READ_TRANSACTION = "queryAllCars";


module.exports = {
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
    }
};



async function readTransaction() {
    //get contract form hyperledger network
    let contract = await getHyperLedgerContract();

    // Evaluate the specified  transaction.
    let result = await contract.evaluateTransaction(READ_TRANSACTION);


    var obj_response = JSON.parse(result.toString());

    //var arr = Array.prototype.slice.call(result, 0);
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

async function getHyperLedgerContract() {
    // Create a new file system based wallet for managing identities.
    const walletPath = path.join(process.cwd(), '/scrocco_network/javascript/wallet');
    const wallet = new FileSystemWallet(walletPath);
    console.log(walletPath);

    // Check to see if we've already enrolled the user.
    const userExists = await wallet.exists(USER_NAME);
    if (!userExists) {
        //Run the registerUser.js application before retrying
        //Or check working directory
        throw new Error("An identity for the user " + USER_NAME +" does not exist in the wallet");
    }

    // Create a new gateway for connecting to our peer node.
    const gateway = new Gateway();
    await gateway.connect(ccpPath, { wallet, identity: USER_NAME, discovery: { enabled: true, asLocalhost: true } });

    // Get the network (channel) our contract is deployed to.
    const network = await gateway.getNetwork(CHANNEL_NAME);

    // return contract from the network.
    return network.getContract(CONTRACT_NAME);
}

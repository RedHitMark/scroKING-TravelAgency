const { FileSystemWallet, Gateway } = require('fabric-network');
const path = require('path');

const ccpPath = path.resolve(__dirname, '..', '..', 'first-network', 'connection-org1.json');

const USER_NAME = "scrocco-user";
const CHANNEL_NAME = "mychannel";
const CONTRACT_NAME = "fabcar";
const TRANSACTION_NAME = "queryAllCars";


module.exports = {
    getAllTransactions : async function() {
        //get contract form hyperledger network
        let result = await executeHyperLedgerTransaction(TRANSACTION_NAME);

        var json_response = JSON.parse(result.toString());

        //var arr = Array.prototype.slice.call(result, 0);
        json_response = json_response.filter( (value) => {
            return value.Key !== "CAR0" && value.Key !== "CAR1" && value.Key !== "CAR2" && value.Key !== "CAR3" && value.Key !== "CAR4" && value.Key !== "CAR5" && value.Key !== "CAR6" && value.Key !== "CAR7" && value.Key !== "CAR8" && value.Key !== "CAR9";
        });

        return json_response;
    }
};



async function executeHyperLedgerTransaction() {
    // Create a new file system based wallet for managing identities.
    const walletPath = path.join(process.cwd(), 'wallet');
    const wallet = new FileSystemWallet(walletPath);

    // Check to see if we've already enrolled the user.
    const userExists = await wallet.exists(USER_NAME);
    if (!userExists) {
        throw new Error('An identity for the user "user1" does not exist in the wallet');
        //console.log('Run the registerUser.js application before retrying');
    }

    // Create a new gateway for connecting to our peer node.
    const gateway = new Gateway();
    await gateway.connect(ccpPath, { wallet, identity: USER_NAME, discovery: { enabled: true, asLocalhost: true } });

    // Get the network (channel) our contract is deployed to.
    const network = await gateway.getNetwork(CHANNEL_NAME);

    // return contract from the network.
    const contract = network.getContract(CONTRACT_NAME);

    // Evaluate the specified  transaction.
    const result = await contract.evaluateTransaction(TRANSACTION_NAME);
}



/*async function main() {
    try {

        // Create a new file system based wallet for managing identities.
        const walletPath = path.join(process.cwd(), 'wallet');
        const wallet = new FileSystemWallet(walletPath);
        console.log(`Wallet path: ${walletPath}`);

        // Check to see if we've already enrolled the user.
        const userExists = await wallet.exists('scrocco-user');
        if (!userExists) {
            console.log('An identity for the user "user1" does not exist in the wallet');
            console.log('Run the registerUser.js application before retrying');
            return;
        }

        // Create a new gateway for connecting to our peer node.
        const gateway = new Gateway();
        await gateway.connect(ccpPath, { wallet, identity: 'scrocco-user', discovery: { enabled: true, asLocalhost: true } });

        // Get the network (channel) our contract is deployed to.
        const network = await gateway.getNetwork('mychannel');

        // Get the contract from the network.
        const contract = network.getContract('fabcar');

        // Evaluate the specified transaction.
        // queryCar transaction - requires 1 argument, ex: ('queryCar', 'CAR4')
        // queryAllCars transaction - requires no arguments, ex: ('queryAllCars')
        const result = await contract.evaluateTransaction('queryAllCars');

        /!*
        arr = arr.filter( (value) => {
            return !value.Key.startWith("CAR");
        });*!/

        console.log(`Transaction has been evaluated, result is: ${result.toString()}`);

        var js_string = "{" + result.toString() * "}";
        var obj = JSON.parse(result.toString());

        //var arr = Array.prototype.slice.call(result, 0);
        obj = obj.filter( (value) => {
            return value.Key != "CAR0" && value.Key != "CAR1" && value.Key != "CAR2" && value.Key != "CAR3" && value.Key != "CAR4" && value.Key != "CAR5" && value.Key != "CAR6" && value.Key != "CAR7" && value.Key != "CAR8" && value.Key != "CAR9";
        });

        console.log(obj)

    } catch (error) {
        console.error(`Failed to evaluate transaction: ${error}`);
        process.exit(1);
    }
}

main();*/

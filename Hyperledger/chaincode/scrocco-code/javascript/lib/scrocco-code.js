/*
 * SPDX-License-Identifier: Apache-2.0
 */

'use strict';

const { Contract } = require('fabric-contract-api');

class ScroccoCode extends Contract {

    async initLedger(ctx) {
    }

    async queryTransaction(ctx, transactionId) {
        const transactionAsBytes = await ctx.stub.getState(transactionId); // get the transaction from chaincode state
        if (!transactionAsBytes || transactionAsBytes.length === 0) {
            throw new Error(`${transactionId} does not exist`);
        }
        console.log(transactionAsBytes.toString());
        return transactionAsBytes.toString();
    }

    async createTranscation(ctx, transactionId, userId, money, timestamp, description) {
        console.info('============= START : Create Transaction ===========');

        const transaction = {
            userId,
            docType: 'transaction',
            money,
            timestamp,
            description,
        };

        await ctx.stub.putState(transactionId, Buffer.from(JSON.stringify(transaction)));
        console.info('============= END : Create Transaction ===========');
    }

    async queryAll(ctx) {
        const startKey = '10';
        const endKey = '999';

        const iterator = await ctx.stub.getStateByRange(startKey, endKey);

        const allResults = [];
        while (true) {
            const res = await iterator.next();

            if (res.value && res.value.value.toString()) {
                console.log(res.value.value.toString('utf8'));

                const Key = res.value.key;
                let Record;
                try {
                    Record = JSON.parse(res.value.value.toString('utf8'));
                } catch (err) {
                    console.log(err);
                    Record = res.value.value.toString('utf8');
                }
                allResults.push({ Key, Record });
            }
            if (res.done) {
                console.log('end of data');
                await iterator.close();
                console.info(allResults);
                return JSON.stringify(allResults);
            }
        }
    }

}

module.exports = ScroccoCode;

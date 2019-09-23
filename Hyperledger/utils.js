module.exports = {
    getClientAddress: function (request) {
        return request.headers['x-forwarded-for'] || request.connection.remoteAddress;
    },
    getTimestamp : function() {
        return new Date().getTime();
    }
};

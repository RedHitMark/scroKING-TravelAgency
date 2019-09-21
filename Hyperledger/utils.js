module.exports = {
    getClientAddress: function (request) {
        return request.headers['x-forwarded-for'] || request.connection.remoteAddress;
    },
    bar: function () {
        return "example";
    }
};

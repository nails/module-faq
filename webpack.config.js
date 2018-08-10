var path = require('path');

module.exports = {
    entry: './assets/js/admin.faq.js',
    output: {
        filename: 'admin.faq.min.js',
        path: path.resolve(__dirname, 'assets/js/')
    },
    mode: 'production'
};

var path = require('path');

module.exports = {
    entry: "./assets/es6/app.js",
    output: {
        path: path.join(__dirname, 'build'),
        filename: "bundle.js"
    },
    module: {
        loaders: [
            { 
                test: /\.css$/, 
                loader: "style!css" 
            }
        ]
    }
};
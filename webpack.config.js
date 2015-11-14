var webpack = require('webpack');  

module.exports = {  
    entry: {
        a: [
             "./js/app.js",
            'webpack/hot/only-dev-server'
            ],
        b: [ 
            './assets/es6/mainPlayerApp.js',
            'webpack/hot/only-dev-server'
            ]
    },
    output: {
        path: __dirname + '/build',
        filename: "[name].bundle.js"
    },
    module: {
        loaders: [
            { test: /\.js?$/, loaders: ['react-hot', 'babel'], exclude: /node_modules/ },
            { test: /\.js$/, exclude: /node_modules/, loader: 'babel-loader'},
            { test: /\.css$/, loader: "style-loader!css-loader" },
            {
                test: /\.(jpe?g|png|gif|svg)$/i,
                loaders: [
                    'file?hash=sha512&digest=hex&name=[hash].[ext]',
                    'image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false'
                ]
            }
        ]
    },
    plugins: [
      new webpack.NoErrorsPlugin()
    ]

};
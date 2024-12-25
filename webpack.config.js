const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin')
const TerserPlugin = require('terser-webpack-plugin')

module.exports = (env, argv) => {
  const isDevelopment = argv.mode === 'development'

  return {
    entry: {
      // JavaScript entries
      main: './assets/js/src/main.ts',
      admin: './assets/js/src/admin.ts',
      // CSS entries
      styles: './assets/css/main.css',
    },
    output: {
      filename: 'js/[name].js',
      path: path.resolve(__dirname, 'dist'),
      clean: true,
      // Prevent JS file creation for CSS entries
      assetModuleFilename: 'assets/[name][ext]',
    },
    devtool: isDevelopment ? 'source-map' : false,
    module: {
      rules: [
        // TypeScript/JavaScript handling
        {
          test: /\.(ts|js)x?$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env', '@babel/preset-typescript'],
            },
          },
        },
        // SASS/SCSS/CSS handling with PostCSS
        {
          test: /\.(sa|sc|c)ss$/,
          use: [
            MiniCssExtractPlugin.loader,
            {
              loader: 'css-loader',
              options: {
                importLoaders: 2,
                sourceMap: isDevelopment,
              },
            },
            {
              loader: 'postcss-loader',
              options: {
                sourceMap: isDevelopment,
              },
            },
            {
              loader: 'sass-loader',
              options: {
                sourceMap: isDevelopment,
              },
            },
          ],
        },
        // Asset handling
        {
          test: /\.(png|svg|jpg|jpeg|gif)$/i,
          type: 'asset/resource',
          generator: {
            filename: 'images/[name][ext]',
          },
        },
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/i,
          type: 'asset/resource',
          generator: {
            filename: 'fonts/[name][ext]',
          },
        },
      ],
    },
    optimization: {
      minimizer: [
        new CssMinimizerPlugin({
          minimizerOptions: {
            preset: [
              'default',
              {
                discardComments: { removeAll: true },
              },
            ],
          },
        }),
        new TerserPlugin({
          terserOptions: {
            format: {
              comments: false,
            },
          },
          extractComments: false,
        }),
      ],
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: '../dist/css/[name].css',
      }),
    ],
    resolve: {
      extensions: ['.tsx', '.ts', '.js', '.scss', '.css'],
      alias: {
        '@': path.resolve(__dirname, 'assets/js/src'),
      },
    },
  }
}

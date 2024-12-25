module.exports = (ctx) => ({
  plugins: [
    [
      'postcss-preset-env',
      {
        stage: 1,
        features: {
          'nesting-rules': true,
          'custom-properties': true,
          'custom-media-queries': true,
        },
        autoprefixer: {
          grid: true,
        },
      },
    ],
    ctx.mode === 'production'
      ? require('cssnano')({
          preset: [
            'default',
            {
              discardComments: { removeAll: true },
            },
          ],
        })
      : false,
  ].filter(Boolean),
})

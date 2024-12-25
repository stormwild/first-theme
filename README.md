# First Theme

A clean and minimal WordPress theme with modern development practices.

## Theme Structure

```
first-theme/
├── assets/                 # Frontend assets
│   ├── css/               # CSS files
│   │   ├── custom/        # Custom CSS modules
│   │   └── vendor/        # Third-party CSS
│   ├── js/                # JavaScript files
│   │   ├── src/           # Source JS/TS files
│   │   │   ├── modules/   # JS/TS modules
│   │   │   └── utils/     # Utility functions
│   │   └── dist/          # Compiled JS files
│   ├── images/            # Theme images
│   └── fonts/             # Custom fonts
├── inc/                   # Theme PHP includes
│   ├── customizer.php     # Theme customizer settings
│   ├── template-tags.php  # Custom template tags
│   ├── helpers.php        # Helper functions
│   └── assets.php         # Asset management
├── template-parts/        # Reusable template parts
│   ├── header/           # Header components
│   ├── footer/           # Footer components
│   ├── content/          # Content templates
│   ├── navigation/       # Navigation components
│   └── components/       # Reusable UI components
├── languages/            # Translation files
├── node_modules/         # NPM packages (git-ignored)
├── package.json          # NPM configuration
├── webpack.config.js     # Webpack configuration
├── tsconfig.json         # TypeScript configuration
├── style.css            # Main theme stylesheet
├── functions.php        # Theme functions
└── [Template Files]     # WordPress template files
```

## Development Setup

1. Install dependencies:

```bash
npm install
```

2. Development workflow:

```bash
# Start development with watch mode
npm run dev

# Build for production
npm run build
```

## Asset Management

- JavaScript/TypeScript files are processed through Webpack
- SASS/SCSS is compiled to CSS
- Images are optimized during build
- Supports modern JavaScript features and TypeScript

## Template Structure

- Template parts are organized by functionality
- Reusable components are stored in template-parts/components
- Header and footer variations in respective directories
- Content templates for different post types

## Customization

Theme customization options are managed through the WordPress Customizer API. See inc/customizer.php for available options.

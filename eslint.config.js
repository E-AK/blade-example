import js from '@eslint/js';
import prettier from 'eslint-plugin-prettier';
import globals from 'globals';

export default [
    js.configs.recommended,

    {
        files: ['resources/js/**/*.js'],
        ignores: ['node_modules/**', 'public/**', 'vendor/**', 'storage/**'],

        languageOptions: {
            ecmaVersion: 'latest',
            sourceType: 'module',
            globals: {
                ...globals.browser,
                ...globals.node,
                $: 'readonly',
                jQuery: 'readonly'
            }
        },

        plugins: {
            prettier
        },

        rules: {
            'no-unused-vars': 'warn',
            'no-console': 'off',
            eqeqeq: 'error',
            curly: 'error',
            'prettier/prettier': 'warn'
        }
    }
];

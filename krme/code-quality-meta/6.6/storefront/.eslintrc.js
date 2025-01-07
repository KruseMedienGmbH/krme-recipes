module.exports = {
    extends: [
        '../../../../vendor/shopware/storefront/Resources/app/storefront/.eslintrc.js',
    ],
    overrides: [
        {
            files: ['**/*.ts', '**/*.tsx'],
            parserOptions: {
                tsconfigRootDir: __dirname,
                project: ['./tsconfig.json'],
            },
            rules: {
                '@typescript-eslint/no-unsafe-member-access': 'warn',
                '@typescript-eslint/no-unsafe-call': 'warn',
                '@typescript-eslint/no-unsafe-assignment': 'warn',
                '@typescript-eslint/no-unsafe-return': 'warn',
                '@typescript-eslint/require-await': 'warn',
                '@typescript-eslint/no-unsafe-argument': 'warn',
                'vuejs-accessibility/click-events-have-key-events': 'warn',
            },
        },
    ],
};

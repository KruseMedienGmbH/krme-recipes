module.exports = {
    extends: [
        '../../../../vendor/shopware/administration/Resources/app/administration/.eslintrc.js',
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
    rules: {
        'sw-core-rules/require-explicit-emits': 'off',
        'sw-core-rules/require-package-annotation': 'off',
    },
};

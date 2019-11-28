module.exports = {
    "env": {
        "browser": true,
        "es6": true
    },
    "extends": [
        "eslint:recommended"
    ],
    "parserOptions": {
        "ecmaVersion": 2015,
        "sourceType": "module"
    },
    "rules": {
        "indent": [
            "warn",
            2
        ],
        "linebreak-style": [
            "error",
            "unix"
        ],
        "quotes": [
            "error",
            "single"
        ],
        "semi": [
            "error",
            "always"
        ],
        "no-undef": "off",
        "strict": "off",
        "no-unused-vars": "off",
        "no-case-declarations": "off",
        "no-console": [
            "warn",
            { allow: ["warn", "error"] }
        ],
        "newline-before-return": "error",
        "no-useless-escape": "warn",
        "object-curly-spacing": ["error", "never"],
        "array-bracket-spacing": ["error", "never"],
        "space-in-parens": ["error", "never"]
    }
};

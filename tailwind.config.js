module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
    ],
    darkMode: "media", // or 'media' or 'class'
    theme: {
        container: {
            center: true
        },
        extend: {
            outline: {
                blue: "0.5px solid #0000ff"
            },
            fontFamily: {
                rubik: ["Rubik", "sans-serif"],
                helve: ["Helvetica"],
                inter: ["Inter", "sans-serif"],
                open: ["Open Sans", "sans-serif"],
                quest: ["Questral", "sans-serif"]
            }
        }
    },
    variants: {
        extend: {
            opacity: ["disabled"]
            // backgroundColor: ["checked"],
            // borderColor: ["checked"]
        }
    },
    plugins: [require("@tailwindcss/forms")]
};

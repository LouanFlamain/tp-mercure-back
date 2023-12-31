/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{js,jsx,ts,tsx}"],
  theme: {
    extend: {
      borderWidth: {
        1: "1px",
      },
      colors: {
        clear: "#F0F8FF",
        dark: "#0C1318",
        darker: "#1F2C33",
        lightDarker: "#111B21",
        greyLighter: "#373F47",
        grey: "#293238",
      },
      width: {
        112: "36rem",
      },
    },
  },
  plugins: [require("daisyui")],
};

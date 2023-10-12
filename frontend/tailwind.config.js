/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{js,jsx,ts,tsx}"],
  theme: {
    extend: {
      colors: {
        clear: "#F0F8FF",
        dark: "#1D232A",
      },
    },
  },
  plugins: [require("daisyui")],
};

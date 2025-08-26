/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php", "./assets/js/**/*.js"],
  theme: {
    extend: {
      colors: {
        accent: {
          DEFAULT: "#C17D2C",
          dark: "#8B5A1E",
          light: "#E6C08C",
        },
        warm: {
          bg: "#F4F0E8",
        },
      },
      fontFamily: {
        sans: ["Inter", "ui-sans-serif", "system-ui", "sans-serif"],
        display: ["Playfair Display", "Georgia", "serif"],
      },
      borderRadius: {
        '2xl': '1rem'
      }
    },
  },
  plugins: [],
};

/** @type {import('tailwindcss').Config} */

export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        christmas: {
          red: '#E74C3C',
          green: '#2ECC71',
          gold: '#F39C12',
        }
      }
    },
  },
  plugins: [],
}

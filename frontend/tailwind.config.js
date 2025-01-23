/** @type {import('tailwindcss').Config} */
export default {
  content: ['./public/index.html', './src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    colors: {
      'green-dark': '#395144',
      'green-dark-transparent': 'rgba(57, 81, 68, 0.5)',
      'green-light': '#478746',
      'green-light-transparent': 'rgba(71, 135, 70, 0.5)',
      beige: '#F0EBCE',
      'beige-transparent': 'rgba(240, 235, 206, 0.5)',
      'beige-less-transparent': 'rgba(240, 235, 206, 0.3)',
      'beige-light': '#faf9f0',
      'gray-light': '#cbd5e0',
      'gray-dark': '#959aa0',
      red: '#AF1740',
    },
    fontFamily: {},
    extend: {},
  },
  variants: {
    extend: {
      boxShadow: ['hover', 'focus'],
      borderColor: ['hover', 'focus'],
    },
  },
  plugins: [],
  container: {
    center: true,
  },
};
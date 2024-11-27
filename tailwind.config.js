/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.{html,js,php}", "./node_modules/flowbite/**/*.js"],
  theme: {
    colors:{
     ' bodyColor':'#F0F0F0',
      'principalColor':'#9175DC',
      'darkColor':'#202A25',
      'complementary':'#2E166F',
      'pointColor':'#B6244F'

    },
    fontFamily:{
      sf: ['SF Pro Display', 'sans-serif'],
      gokhan: ['Gokhan', 'sans-serif'],
      bungee: ['Bungee', 'cursive'],
      inter : ['Inter 18pt'],
      ubuntu: ['Ubuntu']
    },
    extend: {},
  },
  plugins: [
    require('flowbite/plugin')
  ],
}


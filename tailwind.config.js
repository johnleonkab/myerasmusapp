/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    'node_modules/preline/dist/*.js',

  ],

  safelist:[
    "bg-[#F9C80E]",
    "bg-[#95C623]",
    "bg-[#58B09C]",
    "bg-[#EA3546]",
    "bg-[#17C3B2]",
    "bg-[#79BEEE]",
    "bg-[#2B4162]",
    "bg-[#FFCB77]",
  ],

  theme: {
    extend: {
      fontFamily:{
        'quicksand': ['Quicksand', 'sans'],
        'varela': ['Varela Round', 'sans'],
      }
    },
  },
  plugins: [
    require('preline/plugin'),
  ],
}


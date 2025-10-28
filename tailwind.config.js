export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        poppins: ["Poppins", "sans-serif"],
        sofia: ["Sofia Sans", "sans-serif"],
      },
      colors: {
        'selecta-blue': '#373C90',
      },
    },
  },
  plugins: [],
};

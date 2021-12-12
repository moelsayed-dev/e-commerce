module.exports = {
  purge: [],
  purge: [
     './resources/**/*.blade.php',
     './resources/**/*.js',
     './resources/**/*.vue',
   ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        fontFamily: {
            'robo': ['Roboto']
        },
        colors: {
            gray: {
                bg: '#535353'
            }
        },
    },
  },
  variants: {
    extend: {
        opacity: ['disabled'],
        cursor: ['disabled'],
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

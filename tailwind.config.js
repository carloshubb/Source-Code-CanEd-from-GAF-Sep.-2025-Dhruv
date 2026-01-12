module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.{html,js,vue}',
    ],

    theme: {
        fontFamily: {
            Futura: ['Futura', "cursive"],
            FuturaItalic: ['FuturaItalic', "cursive"],
            FuturaMedium: ['FuturaMedium', "cursive"],
            FuturaBold: ['FuturaBold', "cursive"],
            FuturaBdCnBT: ['FuturaBdCnBT', "cursive"],
            FuturaMdCnBT: ['FuturaMdCnBT', "cursive"],
        },
        extend: {
            colors: {
                primary: '#b1040e',
                secondaryRed: '#C1363E',
                secondary: '#333333',
                aero: '#106BC7',
                dark: '#111827',
                secondaryDark: '#4B5563',
                primaryDark: '#830B0B',
                Dark:'#384058',
            },
            boxShadow: {
                '3xl': '0 0rem 1rem rgba(0,0,0,.175)',
                'custom': 'rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px',
            },
            fontSize: {
                regular: ['18px', '22px']
            },
            screens: {
                'desktop': '1920px',
                'mobile': '375px'
              },
              keyframes: {
                  wiggle: {
                      '0%, 100%': {
                          transform: 'rotate(-4deg)'
                      },
                      '50%': {
                          transform: 'rotate(4deg)'
                      },
                  }
              },
              animation: {
                  'wiggle': 'wiggle 3s ease-in-out infinite',
                  'bounce': 'bounce 3s ease-in-out infinite',
              },

        },
    },

    plugins: [require('@tailwindcss/forms')],
};

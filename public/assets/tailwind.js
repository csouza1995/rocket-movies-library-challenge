tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          'display': ['Rammetto One', 'sans-serif'],
          'title': ['Rajdhani', 'sans-serif'],
          'body': ['Nunito Sans', 'sans-serif'],
        },
        colors: {
          'purple': {
            'base': '#892CCD',
            'light': '#A85FDD',
          },

          'gray': {
            '100': '#0F0F1A',
            '200': '#131320',
            '300': '#1A1B2D',
            '400': '#45455F',
            '500': '#7A7B9F',
            '600': '#B5B6C9',
            '700': '#E4E5EC',
            '800': '#F4F5F9',
          },

          'error': {
            'base': '#D04048',
            'light': '#F77980',
          },

          'rating': '#0F0F1ACC'
        }
      }
    }
  }
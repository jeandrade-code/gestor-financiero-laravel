/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                /*
                 * "Evergreen" accent. A muted, editorial green instead of the
                 * default SaaS blue — calmer, more trustworthy, less generic.
                 */
                brand: {
                    50: '#f1f7f4',
                    100: '#e2efe8',
                    200: '#c5dfd3',
                    300: '#9ac7b4',
                    400: '#66a98f',
                    500: '#3f8b6e',
                    600: '#266f55',
                    700: '#1b5a45',
                    800: '#174838',
                    900: '#133b2e',
                    950: '#0a251c',
                },
                /*
                 * Warm neutral scale. Slight green/stone undertone keeps the
                 * interface from looking like a default Tailwind template.
                 */
                neutral: {
                    0: '#ffffff',
                    50: '#fafaf8',
                    100: '#f4f5f2',
                    200: '#e7e9e4',
                    300: '#d4d8d1',
                    400: '#a7aea6',
                    500: '#7c857d',
                    600: '#5b645d',
                    700: '#424a44',
                    800: '#2a312d',
                    900: '#181e1a',
                    950: '#0c110e',
                },
                income: {
                    50: '#eef7f2',
                    100: '#d9eee3',
                    200: '#b4ddc8',
                    300: '#84c4a7',
                    400: '#53a784',
                    500: '#2f8c67',
                    600: '#1f7353',
                    700: '#1b5b43',
                    800: '#174838',
                    900: '#12392c',
                },
                expense: {
                    50: '#fbf1ef',
                    100: '#f6ded9',
                    200: '#ecbfb6',
                    300: '#df9a8c',
                    400: '#cc7160',
                    500: '#b4523f',
                    600: '#9c3f2e',
                    700: '#7f3325',
                    800: '#682b20',
                    900: '#55251c',
                },
                warning: {
                    50: '#fbf6e8',
                    100: '#f5eac8',
                    200: '#ead496',
                    300: '#dbb95f',
                    400: '#c99d34',
                    500: '#b0851f',
                    600: '#936b18',
                    700: '#775314',
                    800: '#5f4213',
                    900: '#4c3512',
                },
            },

            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                display: ['Instrument Serif', 'ui-serif', 'Georgia', 'Cambria', 'Times New Roman', 'serif'],
                mono: ['JetBrains Mono', 'ui-monospace', 'SFMono-Regular', 'Menlo', 'Consolas', 'monospace'],
            },

            fontSize: {
                'display-xl': ['clamp(2.75rem, 4.6vw, 4rem)', { lineHeight: '1.04', letterSpacing: '-0.03em', fontWeight: '400' }],
                'display-lg': ['clamp(2.25rem, 3.6vw, 3rem)', { lineHeight: '1.08', letterSpacing: '-0.025em', fontWeight: '400' }],
                'display-md': ['clamp(1.75rem, 2.6vw, 2.25rem)', { lineHeight: '1.16', letterSpacing: '-0.02em', fontWeight: '400' }],
                'display-sm': ['clamp(1.5rem, 2vw, 1.875rem)', { lineHeight: '1.2', letterSpacing: '-0.015em', fontWeight: '500' }],
                'kpi': ['1.75rem', { lineHeight: '1.15', letterSpacing: '-0.02em', fontWeight: '600' }],
                'kpi-sm': ['1.375rem', { lineHeight: '1.2', letterSpacing: '-0.015em', fontWeight: '600' }],
                'heading-xl': ['1.5rem', { lineHeight: '1.25', letterSpacing: '-0.015em', fontWeight: '600' }],
                'heading-lg': ['1.25rem', { lineHeight: '1.3', letterSpacing: '-0.01em', fontWeight: '600' }],
                'heading-md': ['1.0625rem', { lineHeight: '1.4', fontWeight: '600' }],
                'heading-sm': ['0.9375rem', { lineHeight: '1.45', fontWeight: '600' }],
                'body-lg': ['1.0625rem', { lineHeight: '1.65', fontWeight: '400' }],
                'body': ['0.9375rem', { lineHeight: '1.6', fontWeight: '400' }],
                'body-sm': ['0.8125rem', { lineHeight: '1.5', fontWeight: '400' }],
                'caption': ['0.6875rem', { lineHeight: '1.45', letterSpacing: '0.02em', fontWeight: '500' }],
                'micro': ['0.625rem', { lineHeight: '1.4', letterSpacing: '0.08em', fontWeight: '500' }],
                'mono-sm': ['0.75rem', { lineHeight: '1.5', fontWeight: '400' }],
                'mono': ['0.8125rem', { lineHeight: '1.6', fontWeight: '400' }],
            },

            borderRadius: {
                none: '0',
                sm: '0.25rem',
                DEFAULT: '0.375rem',
                md: '0.5rem',
                lg: '0.625rem',
                xl: '0.75rem',
                '2xl': '1rem',
                '3xl': '1.25rem',
                full: '9999px',
            },

            boxShadow: {
                xs: '0 1px 2px 0 rgb(16 24 20 / 0.04)',
                sm: '0 1px 2px 0 rgb(16 24 20 / 0.05)',
                DEFAULT: '0 1px 3px 0 rgb(16 24 20 / 0.06), 0 1px 2px -1px rgb(16 24 20 / 0.05)',
                md: '0 4px 10px -2px rgb(16 24 20 / 0.07), 0 2px 4px -2px rgb(16 24 20 / 0.04)',
                lg: '0 12px 28px -8px rgb(16 24 20 / 0.10), 0 4px 8px -4px rgb(16 24 20 / 0.05)',
                xl: '0 20px 40px -12px rgb(16 24 20 / 0.14)',
                card: '0 1px 2px rgb(16 24 20 / 0.04), 0 1px 3px rgb(16 24 20 / 0.03)',
                'card-hover': '0 8px 20px -6px rgb(16 24 20 / 0.10), 0 2px 4px -2px rgb(16 24 20 / 0.04)',
                menu: '0 10px 30px -6px rgb(16 24 20 / 0.14), 0 2px 6px -2px rgb(16 24 20 / 0.06)',
                focus: '0 0 0 3px rgb(63 139 110 / 0.28)',
            },

            transitionTimingFunction: {
                'ease-in': 'cubic-bezier(0.4, 0, 1, 1)',
                'ease-out': 'cubic-bezier(0.16, 1, 0.3, 1)',
                'ease-in-out': 'cubic-bezier(0.65, 0, 0.35, 1)',
            },

            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeOut: {
                    '0%': { opacity: '1' },
                    '100%': { opacity: '0' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(6px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                slideDown: {
                    '0%': { transform: 'translateY(-6px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },

            animation: {
                'fade-in': 'fadeIn 160ms ease-out',
                'slide-up': 'slideUp 200ms cubic-bezier(0.16, 1, 0.3, 1)',
                'slide-down': 'slideDown 200ms cubic-bezier(0.16, 1, 0.3, 1)',
            },

            maxWidth: {
                prose: '68ch',
            },

            zIndex: {
                0: '0',
                10: '10',
                20: '20',
                30: '30',
                40: '40',
                50: '50',
                dropdown: '100',
                sticky: '200',
                modal: '300',
                popover: '400',
                tooltip: '500',
                toast: '600',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
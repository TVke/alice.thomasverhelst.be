/*

Tailwind - The Utility-First CSS Framework

A project by Adam Wathan (@adamwathan), Jonathan Reinink (@reinink),
David Hemphill (@davidhemphill) and Steve Schoger (@steveschoger).

Welcome to the Tailwind config file. This is where you can customize
Tailwind specifically for your project. Don't be intimidated by the
length of this file. It's really just a big JavaScript object and
we've done our very best to explain each section.

View the full documentation at https://tailwindcss.com.


|-------------------------------------------------------------------------------
| The default config
|-------------------------------------------------------------------------------
|
| This variable contains the default Tailwind config. You don't have
| to use it, but it can sometimes be helpful to have available. For
| example, you may choose to merge your custom configuration
| values with some of the Tailwind defaults.
|
*/

// let defaultConfig = require('tailwindcss/defaultConfig')()

/*
|-------------------------------------------------------------------------------
| Colors                                    https://tailwindcss.com/docs/colors
|-------------------------------------------------------------------------------
|
| Here you can specify the colors used in your project. To get you started,
| we've provided a generous palette of great looking colors that are perfect
| for prototyping, but don't hesitate to change them for your project. You
| own these colors, nothing will break if you change everything about them.
|
| We've used literal color names ("red", "blue", etc.) for the default
| palette, but if you'd rather use functional names like "primary" and
| "secondary", or even a numeric scale like "100" and "200", go for it.
|
*/

let colors = {
    transparent: "transparent",
    "white-transparent": "rgba(255,255,255,0.9)",
    "black-transparent": "rgba(0,0,0,0.6)",
    "active-transparent": "rgba(100,100,100,0.6)",

    'pawn-blue': '#36A9E1',
    'pawn-green': '#95C11F',
    'pawn-red': '#BE1622',

    'alice-lightest': '#EBF6FC',
    'alice-lighter': '#AFDDF3',
    'alice-light': '#72C3EA',
    alice: '#36A9E1',
    'alice-dark': '#3198CB',
    'alice-darker': '#206587',
    'alice-darkest': '#103344',

    black: "#22292f",
    "grey-darkest": "#3d4852",
    "grey-darker": "#606f7b",
    "grey-dark": "#8795a1",
    grey: "#b8c2cc",
    "grey-light": "#dae1e7",
    "grey-lighter": "#f1f5f8",
    "grey-lightest": "#f8fafc",
    white: "#ffffff",

    "red-darkest": "#3b0d0c",
    "red-darker": "#621b18",
    "red-dark": "#cc1f1a",
    red: "#e3342f",
    "red-light": "#ef5753",
    "red-lighter": "#f9acaa",
    "red-lightest": "#fcebea",

    "orange-darkest": "#462a16",
    "orange-darker": "#613b1f",
    "orange-dark": "#de751f",
    orange: "#f6993f",
    "orange-light": "#faad63",
    "orange-lighter": "#fcd9b6",
    "orange-lightest": "#fff5eb",

    "yellow-darkest": "#453411",
    "yellow-darker": "#684f1d",
    "yellow-dark": "#f2d024",
    yellow: "#ffed4a",
    "yellow-light": "#fff382",
    "yellow-lighter": "#fff9c2",
    "yellow-lightest": "#fcfbeb",

    "green-darkest": "#0f2f21",
    "green-darker": "#1a4731",
    "green-dark": "#1f9d55",
    green: "#38c172",
    "green-light": "#51d88a",
    "green-lighter": "#a2f5bf",
    "green-lightest": "#e3fcec",

    "teal-darkest": "#0d3331",
    "teal-darker": "#20504f",
    "teal-dark": "#38a89d",
    teal: "#4dc0b5",
    "teal-light": "#64d5ca",
    "teal-lighter": "#a0f0ed",
    "teal-lightest": "#e8fffe",

    "blue-darkest": "#12283a",
    "blue-darker": "#1c3d5a",
    "blue-dark": "#2779bd",
    blue: "#3490dc",
    "blue-light": "#6cb2eb",
    "blue-lighter": "#bcdefa",
    "blue-lightest": "#eff8ff",

    "indigo-darkest": "#191e38",
    "indigo-darker": "#2f365f",
    "indigo-dark": "#5661b3",
    indigo: "#6574cd",
    "indigo-light": "#7886d7",
    "indigo-lighter": "#b2b7ff",
    "indigo-lightest": "#e6e8ff",

    "purple-darkest": "#21183c",
    "purple-darker": "#382b5f",
    "purple-dark": "#794acf",
    purple: "#9561e2",
    "purple-light": "#a779e9",
    "purple-lighter": "#d6bbfc",
    "purple-lightest": "#f3ebff",

    "pink-darkest": "#451225",
    "pink-darker": "#6f213f",
    "pink-dark": "#eb5286",
    pink: "#f66d9b",
    "pink-light": "#fa7ea8",
    "pink-lighter": "#ffbbca",
    "pink-lightest": "#ffebef",

    get ["brand-darkest"]() {
        return this["alice-darkest"];
    },
    get ["brand-darker"]() {
        return this["alice-darker"];
    },
    get ["brand-dark"]() {
        return this["alice-dark"];
    },
    get ["brand"]() {
        return this["alice"];
    },
    get ["brand-light"]() {
        return this["alice-light"];
    },
    get ["brand-lighter"]() {
        return this["alice-lighter"];
    },
    get ["brand-lightest"]() {
        return this["alice-lightest"];
    }
};

module.exports = {
    /*
    |-----------------------------------------------------------------------------
    | Colors                                  https://tailwindcss.com/docs/colors
    |-----------------------------------------------------------------------------
    |
    | The color palette defined above is also assigned to the "colors" key of
    | your Tailwind config. This makes it easy to access them in your CSS
    | using Tailwind's config helper. For example:
    |
    | .error { color: config('colors.red') }
    |
    */

    colors: colors,

    /*
    |-----------------------------------------------------------------------------
    | Screens                      https://tailwindcss.com/docs/responsive-design
    |-----------------------------------------------------------------------------
    |
    | Screens in Tailwind are translated to CSS media queries. They define the
    | responsive breakpoints for your project. By default Tailwind takes a
    | "mobile first" approach, where each screen size represents a minimum
    | viewport width. Feel free to have as few or as many screens as you
    | want, naming them in whatever way you'd prefer for your project.
    |
    | Tailwind also allows for more complex screen definitions, which can be
    | useful in certain situations. Be sure to see the full responsive
    | documentation for a complete list of options.
    |
    | Class name: .{screen}:{utility}
    |
    */

    screens: {
        sm: "450px",
        md: "768px",
        lg: "992px",
        xl: "1200px"
    },

    /*
    |-----------------------------------------------------------------------------
    | Fonts                                    https://tailwindcss.com/docs/fonts
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your project's font stack, or font families.
    | Keep in mind that Tailwind doesn't actually load any fonts for you.
    | If you're using custom fonts you'll need to import them prior to
    | defining them here.
    |
    | By default we provide a native font stack that works remarkably well on
    | any device or OS you're using, since it just uses the default fonts
    | provided by the platform.
    |
    | Class name: .font-{name}
    |
    */

    fonts: {
        noteworthy: [
            "'Noteworthy'",
            "system-ui",
            "BlinkMacSystemFont",
            "-apple-system",
            "Segoe UI",
            "Roboto",
            "Oxygen",
            "Ubuntu",
            "Cantarell",
            "Fira Sans",
            "Droid Sans",
            "Helvetica Neue",
            "sans-serif"
        ],
        sans: [
            "system-ui",
            "BlinkMacSystemFont",
            "-apple-system",
            "Segoe UI",
            "Roboto",
            "Oxygen",
            "Ubuntu",
            "Cantarell",
            "Fira Sans",
            "Droid Sans",
            "Helvetica Neue",
            "sans-serif"
        ],
        serif: [
            "Constantia",
            "Lucida Bright",
            "Lucidabright",
            "Lucida Serif",
            "Lucida",
            "DejaVu Serif",
            "Bitstream Vera Serif",
            "Liberation Serif",
            "Georgia",
            "serif"
        ],
        mono: [
            "Menlo",
            "Monaco",
            "Consolas",
            "Liberation Mono",
            "Courier New",
            "monospace"
        ]
    },

    /*
    |-----------------------------------------------------------------------------
    | Text sizes                         https://tailwindcss.com/docs/text-sizing
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your text sizes. Name these in whatever way
    | makes the most sense to you. We use size names by default, but
    | you're welcome to use a numeric scale or even something else
    | entirely.
    |
    | By default Tailwind uses the "rem" unit type for most measurements.
    | This allows you to set a root font size which all other sizes are
    | then based on. That said, you are free to use whatever units you
    | prefer, be it rems, ems, pixels or other.
    |
    | Class name: .text-{size}
    |
    */

    textSizes: {
        xs: ".75rem", // 12px
        sm: ".875rem", // 14px
        base: "1rem", // 16px
        lg: "1.125rem", // 18px
        xl: "1.25rem", // 20px
        "2xl": "1.5rem", // 24px
        "3xl": "1.875rem", // 30px
        "4xl": "2.25rem", // 36px
        "5xl": "3rem" // 48px
    },

    /*
    |-----------------------------------------------------------------------------
    | Font weights                       https://tailwindcss.com/docs/font-weight
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your font weights. We've provided a list of
    | common font weight names with their respective numeric scale values
    | to get you started. It's unlikely that your project will require
    | all of these, so we recommend removing those you don't need.
    |
    | Class name: .font-{weight}
    |
    */

    fontWeights: {
        hairline: 100,
        thin: 200,
        light: 300,
        normal: 400,
        medium: 500,
        semibold: 600,
        bold: 700,
        extrabold: 800,
        black: 900
    },

    /*
    |-----------------------------------------------------------------------------
    | Leading (line height)              https://tailwindcss.com/docs/line-height
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your line height values, or as we call
    | them in Tailwind, leadings.
    |
    | Class name: .leading-{size}
    |
    */

    leading: {
        none: 1,
        tight: 1.25,
        normal: 1.5,
        loose: 2
    },

    /*
    |-----------------------------------------------------------------------------
    | Tracking (letter spacing)       https://tailwindcss.com/docs/letter-spacing
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your letter spacing values, or as we call
    | them in Tailwind, tracking.
    |
    | Class name: .tracking-{size}
    |
    */

    tracking: {
        tight: "-0.05em",
        normal: "0",
        wide: "0.05em"
    },

    /*
    |-----------------------------------------------------------------------------
    | Text colors                         https://tailwindcss.com/docs/text-color
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your text colors. By default these use the
    | color palette we defined above, however you're welcome to set these
    | independently if that makes sense for your project.
    |
    | Class name: .text-{color}
    |
    */

    textColors: colors,

    /*
    |-----------------------------------------------------------------------------
    | Background colors             https://tailwindcss.com/docs/background-color
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your background colors. By default these use
    | the color palette we defined above, however you're welcome to set
    | these independently if that makes sense for your project.
    |
    | Class name: .bg-{color}
    |
    */

    backgroundColors: colors,

    /*
    |-----------------------------------------------------------------------------
    | Background sizes               https://tailwindcss.com/docs/background-size
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your background sizes. We provide some common
    | values that are useful in most projects, but feel free to add other sizes
    | that are specific to your project here as well.
    |
    | Class name: .bg-{size}
    |
    */

    backgroundSize: {
        auto: "auto",
        cover: "cover",
        contain: "contain"
    },

    /*
    |-----------------------------------------------------------------------------
    | Border widths                     https://tailwindcss.com/docs/border-width
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your border widths. Take note that border
    | widths require a special "default" value set as well. This is the
    | width that will be used when you do not specify a border width.
    |
    | Class name: .border{-side?}{-width?}
    |
    */

    borderWidths: {
        default: "1px",
        "0": "0",
        "2": "2px",
        "4": "4px",
        "8": "8px"
    },

    /*
    |-----------------------------------------------------------------------------
    | Border colors                     https://tailwindcss.com/docs/border-color
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your border colors. By default these use the
    | color palette we defined above, however you're welcome to set these
    | independently if that makes sense for your project.
    |
    | Take note that border colors require a special "default" value set
    | as well. This is the color that will be used when you do not
    | specify a border color.
    |
    | Class name: .border-{color}
    |
    */

    borderColors: global.Object.assign({default: colors["grey-light"]}, colors),

    /*
    |-----------------------------------------------------------------------------
    | Border radius                    https://tailwindcss.com/docs/border-radius
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your border radius values. If a `default` radius
    | is provided, it will be made available as the non-suffixed `.rounded`
    | utility.
    |
    | If your scale includes a `0` value to reset already rounded corners, it's
    | a good idea to put it first so other values are able to override it.
    |
    | Class name: .rounded{-side?}{-size?}
    |
    */

    borderRadius: {
        none: "0",
        sm: ".125rem",
        default: ".25rem",
        lg: ".5rem",
        full: "9999px"
    },

    /*
    |-----------------------------------------------------------------------------
    | Width                                    https://tailwindcss.com/docs/width
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your width utility sizes. These can be
    | percentage based, pixels, rems, or any other units. By default
    | we provide a sensible rem based numeric scale, a percentage
    | based fraction scale, plus some other common use-cases. You
    | can, of course, modify these values as needed.
    |
    |
    | It's also worth mentioning that Tailwind automatically escapes
    | invalid CSS class name characters, which allows you to have
    | awesome classes like .w-2/3.
    |
    | Class name: .w-{size}
    |
    */

    width: {
        auto: "auto",
        px: "1px",
        "1": "0.25rem",
        "2": "0.5rem",
        "3": "0.75rem",
        "4": "1rem",
        "6": "1.5rem",
        "8": "2rem",
        "10": "2.5rem",
        "12": "3rem",
        "16": "4rem",
        "24": "6rem",
        "28": "7rem",
        "32": "8rem",
        "48": "12rem",
        "64": "16rem",
        "1/2": "50%",
        "1/3": "33.33333%",
        "2/3": "66.66667%",
        "1/4": "25%",
        "3/4": "75%",
        "1/5": "20%",
        "1.5/5": "30%",
        "2/5": "40%",
        "3/5": "60%",
        "4/5": "80%",
        "1/6": "16.66667%",
        "5/6": "83.33333%",
        "1/7": "14.28571%",
        "1/8": "12.5%",
        "1/9": "11.11111%",
        "1/11": "9.09091%",
        "1/13": "7.69231%",
        "1/15": "6.66667%",
        "1/17": "5.88235%",
        "1/19": "5.26316%",
        "1/21": "4.76190%",
        "1/23": "4.34783%",
        "1/25": "4%",
        "1/27": "3.70370%",
        "1/29": "3.44828%",
        "1/31": "3.22581%",
        "1/33": "3.03030%",
        "1/35": "2.85714%",
        full: "100%",
        screen: "100vw"
    },

    /*
    |-----------------------------------------------------------------------------
    | Height                                  https://tailwindcss.com/docs/height
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your height utility sizes. These can be
    | percentage based, pixels, rems, or any other units. By default
    | we provide a sensible rem based numeric scale plus some other
    | common use-cases. You can, of course, modify these values as
    | needed.
    |
    | Class name: .h-{size}
    |
    */

    height: {
        auto: "auto",
        px: "1px",
        "1": "0.25rem",
        "2": "0.5rem",
        "3": "0.75rem",
        "4": "1rem",
        "6": "1.5rem",
        "8": "2rem",
        "10": "2.5rem",
        "12": "3rem",
        "16": "4rem",
        "24": "6rem",
        "28": "7rem",
        "32": "8rem",
        "48": "12rem",
        "64": "16rem",
        "1/2": "50%",
        "1/3": "33.33333%",
        "2/3": "66.66667%",
        "1/4": "25%",
        "3/4": "75%",
        "1/5": "20%",
        "1.5/5": "30%",
        "2/5": "40%",
        "3/5": "60%",
        "4/5": "80%",
        "1/6": "16.66667%",
        "5/6": "83.33333%",
        "1/7": "14.28571%",
        "1/9": "11.11111%",
        "1/11": "9.09091%",
        "1/13": "7.69231%",
        "1/15": "6.66667%",
        "1/17": "5.88235%",
        "1/19": "5.26316%",
        "1/21": "4.76190%",
        "1/23": "4.34783%",
        "1/25": "4%",
        "1/27": "3.70370%",
        "1/29": "3.44828%",
        "1/31": "3.22581%",
        "1/33": "3.03030%",
        "1/35": "2.85714%",
        full: "100%",
        screen: "100vh"
    },

    /*
    |-----------------------------------------------------------------------------
    | Minimum width                        https://tailwindcss.com/docs/min-width
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your minimum width utility sizes. These can
    | be percentage based, pixels, rems, or any other units. We provide a
    | couple common use-cases by default. You can, of course, modify
    | these values as needed.
    |
    | Class name: .min-w-{size}
    |
    */

    minWidth: {
        "0": "0",
        full: "100%"
    },

    /*
    |-----------------------------------------------------------------------------
    | Minimum height                      https://tailwindcss.com/docs/min-height
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your minimum height utility sizes. These can
    | be percentage based, pixels, rems, or any other units. We provide a
    | few common use-cases by default. You can, of course, modify these
    | values as needed.
    |
    | Class name: .min-h-{size}
    |
    */

    minHeight: {
        "0": "0",
        full: "100%",
        screen: "100vh"
    },

    /*
    |-----------------------------------------------------------------------------
    | Maximum width                        https://tailwindcss.com/docs/max-width
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your maximum width utility sizes. These can
    | be percentage based, pixels, rems, or any other units. By default
    | we provide a sensible rem based scale and a "full width" size,
    | which is basically a reset utility. You can, of course,
    | modify these values as needed.
    |
    | Class name: .max-w-{size}
    |
    */

    maxWidth: {
        '1/4': "25%",
        xs: "20rem",
        sm: "30rem",
        md: "40rem",
        lg: "50rem",
        xl: "60rem",
        "2xl": "70rem",
        "3xl": "80rem",
        "4xl": "90rem",
        "5xl": "100rem",
        full: "100%",
        screen: "100vh"
    },

    /*
    |-----------------------------------------------------------------------------
    | Maximum height                      https://tailwindcss.com/docs/max-height
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your maximum height utility sizes. These can
    | be percentage based, pixels, rems, or any other units. We provide a
    | couple common use-cases by default. You can, of course, modify
    | these values as needed.
    |
    | Class name: .max-h-{size}
    |
    */

    maxHeight: {
        '1/4': "25%",
        xs: "20rem",
        sm: "30rem",
        md: "40rem",
        lg: "50rem",
        xl: "60rem",
        "2xl": "70rem",
        "3xl": "80rem",
        "4xl": "90rem",
        "5xl": "100rem",
        full: "100%",
        screen: "100vh"
    },

    /*
    |-----------------------------------------------------------------------------
    | Padding                                https://tailwindcss.com/docs/padding
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your padding utility sizes. These can be
    | percentage based, pixels, rems, or any other units. By default we
    | provide a sensible rem based numeric scale plus a couple other
    | common use-cases like "1px". You can, of course, modify these
    | values as needed.
    |
    | Class name: .p{side?}-{size}
    |
    */

    padding: {
        px: "1px",
        "0": "0",
        "1": "0.25rem",
        "2": "0.5rem",
        "3": "0.75rem",
        "4": "1rem",
        "1/5": "30%",
        "6": "1.5rem",
        "8": "2rem",
        "12": "3rem",
        "16": "4rem",
        "24": "6rem",
        "28": "7rem",
        "32": "8rem",
        "48": "12rem",
        "64": "16rem"
    },

    /*
    |-----------------------------------------------------------------------------
    | Margin                                  https://tailwindcss.com/docs/margin
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your margin utility sizes. These can be
    | percentage based, pixels, rems, or any other units. By default we
    | provide a sensible rem based numeric scale plus a couple other
    | common use-cases like "1px". You can, of course, modify these
    | values as needed.
    |
    | Class name: .m{side?}-{size}
    |
    */

    margin: {
        auto: "auto",
        px: "1px",
        "0": "0",
        "1": "0.25rem",
        "2": "0.5rem",
        "3": "0.75rem",
        "4": "1rem",
        "1/5": "30%",
        "6": "1.5rem",
        "8": "2rem",
        "12": "3rem",
        "16": "4rem",
        "24": "6rem",
        "28": "7rem",
        "32": "8rem",
        "48": "12rem",
        "64": "16rem"
    },

    /*
    |-----------------------------------------------------------------------------
    | Negative margin                https://tailwindcss.com/docs/negative-margin
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your negative margin utility sizes. These can
    | be percentage based, pixels, rems, or any other units. By default we
    | provide matching values to the padding scale since these utilities
    | generally get used together. You can, of course, modify these
    | values as needed.
    |
    | Class name: .-m{side?}-{size}
    |
    */

    negativeMargin: {
        px: "1px",
        "0": "0",
        "1": "0.25rem",
        "2": "0.5rem",
        "3": "0.75rem",
        "4": "1rem",
        "6": "1.5rem",
        "8": "2rem",
        "12": "3rem",
        "16": "4rem",
        "24": "6rem",
        "32": "8rem",
        "48": "12rem",
        "64": "16rem"
    },

    /*
    |-----------------------------------------------------------------------------
    | Shadows                                https://tailwindcss.com/docs/shadows
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your shadow utilities. As you can see from
    | the defaults we provide, it's possible to apply multiple shadows
    | per utility using comma separation.
    |
    | If a `default` shadow is provided, it will be made available as the non-
    | suffixed `.shadow` utility.
    |
    | Class name: .shadow-{size?}
    |
    */

    shadows: {
        default: "0 2px 4px 0 rgba(0,0,0,0.10)",
        md: "0 4px 8px 0 rgba(0,0,0,0.12), 0 2px 4px 0 rgba(0,0,0,0.08)",
        lg: "0 15px 30px 0 rgba(0,0,0,0.11), 0 5px 15px 0 rgba(0,0,0,0.08)",
        inner: "inset 0 2px 4px 0 rgba(0,0,0,0.06)",
        outset: "inset 1px 1px 1px rgba(255, 255, 255, 0.1), inset -1px -1px 1px rgba(0, 0, 0, 0.1)",
        'blue-active': "0 0 4px 0 " + colors['pawn-blue'],
        'green-active': "0 0 4px 0 " + colors['pawn-green'],
        'red-active': "0 0 4px 0 " + colors['pawn-red'],
        'white-active': "0 0 4px 0 " + colors['black'],
        'glow': "0 0 150px 0 " + colors['yellow'],
        none: "none"
    },

    /*
    |-----------------------------------------------------------------------------
    | Z-index                                https://tailwindcss.com/docs/z-index
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your z-index utility values. By default we
    | provide a sensible numeric scale. You can, of course, modify these
    | values as needed.
    |
    | Class name: .z-{index}
    |
    */

    zIndex: {
        auto: "auto",
        "-50": -50,
        "-40": -40,
        "-30": -30,
        "-20": -20,
        "-10": -10,
        "0": 0,
        "10": 10,
        "20": 20,
        "30": 30,
        "40": 40,
        "50": 50
    },

    /*
    |-----------------------------------------------------------------------------
    | Opacity                                https://tailwindcss.com/docs/opacity
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your opacity utility values. By default we
    | provide a sensible numeric scale. You can, of course, modify these
    | values as needed.
    |
    | Class name: .opacity-{name}
    |
    */

    opacity: {
        "0": "0",
        "25": ".25",
        "50": ".5",
        "75": ".75",
        "100": "1"
    },

    /*
    |-----------------------------------------------------------------------------
    | SVG fill                                   https://tailwindcss.com/docs/svg
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your SVG fill colors. By default we just provide
    | `fill-current` which sets the fill to the current text color. This lets you
    | specify a fill color using existing text color utilities and helps keep the
    | generated CSS file size down.
    |
    | Class name: .fill-{name}
    |
    */

    svgFill: {
        current: "currentColor"
    },

    /*
    |-----------------------------------------------------------------------------
    | SVG stroke                                 https://tailwindcss.com/docs/svg
    |-----------------------------------------------------------------------------
    |
    | Here is where you define your SVG stroke colors. By default we just provide
    | `stroke-current` which sets the stroke to the current text color. This lets
    | you specify a stroke color using existing text color utilities and helps
    | keep the generated CSS file size down.
    |
    | Class name: .stroke-{name}
    |
    */

    svgStroke: {
        current: "currentColor"
    },

    /*
    |-----------------------------------------------------------------------------
    | transition                       https://github.com/glhd/tailwindcss-plugins
    |-----------------------------------------------------------------------------
    |
    | Class name: .transition-{name}
    |
    */

    transitionDuration: {
        'default': '.25s',
        'slower': '.75s',
        'slow': '.5s',
        'fast': '.15s',
        'faster': '.075s',
    },
    transitionProperty: {
        'default': 'all',
        'all': 'all',
        'none': 'none',
        'bg': 'background',
        'opacity': 'opacity',
        'color': 'color',
        'shadow': 'box-shadow',
        'transform': 'transform',
    },
    transitionTimingFunction: {
        'default': 'ease-in-out',
        'linear': 'linear',
        'ease': 'ease',
        'ease-in': 'ease-in',
        'ease-out': 'ease-out',
        'ease-in-out': 'ease-in-out',
    },
    transitionDelay: {
        'default': '0s',
        'short': '.1s',
        'long': '.2s',
        'longer': '.3s',
        'longest': '.4s',
    },

    /*
    |-----------------------------------------------------------------------------
    | Modules                  https://tailwindcss.com/docs/configuration#modules
    |-----------------------------------------------------------------------------
    |
    | Here is where you control which modules are generated and what variants are
    | generated for each of those modules.
    |
    | Currently supported variants:
    |   - responsive
    |   - hover
    |   - focus
    |   - active
    |   - group-hover
    |
    | To disable a module completely, use `false` instead of an array.
    |
    */

    modules: {
        appearance: ["responsive"],
        backgroundAttachment: ["responsive"],
        backgroundColors: ["responsive", "active", "focus", "hover", "group-hover"],
        backgroundPosition: ["responsive"],
        backgroundRepeat: ["responsive"],
        backgroundSize: ["responsive"],
        borderColors: ["responsive", "active", "focus", "hover", "group-hover"],
        borderRadius: ["responsive"],
        borderStyle: ["responsive"],
        borderWidths: ["responsive"],
        cursor: ["responsive"],
        display: ["responsive"],
        flexbox: ["responsive"],
        float: ["responsive"],
        fonts: ["responsive"],
        fontWeights: ["responsive", "active", "focus", "hover", "group-hover"],
        height: ["responsive"],
        leading: ["responsive"],
        lists: ["responsive"],
        margin: ["responsive"],
        maxHeight: ["responsive"],
        maxWidth: ["responsive"],
        minHeight: ["responsive"],
        minWidth: ["responsive"],
        negativeMargin: ["responsive", "active", "focus", "hover", "group-hover"],
        opacity: ["responsive", "active", "focus", "hover", "group-hover"],
        overflow: ["responsive"],
        padding: ["responsive", "active", "focus", "hover", "group-hover"],
        pointerEvents: ["responsive"],
        position: ["responsive"],
        resize: ["responsive"],
        shadows: ["responsive", "active", "focus", "hover", "group-hover"],
        svgFill: [],
        svgStroke: [],
        textAlign: ["responsive"],
        textColors: ["responsive", "active", "focus", "hover", "group-hover"],
        textSizes: ["responsive"],
        textStyle: ["responsive", "active", "focus", "hover", "group-hover"],
        tracking: ["responsive"],
        userSelect: ["responsive"],
        verticalAlign: ["responsive"],
        visibility: ["responsive"],
        whitespace: ["responsive"],
        width: ["responsive"],
        zIndex: ["responsive", "active", "focus", "hover", "group-hover"]
    },

    /*
    |-----------------------------------------------------------------------------
    | Plugins                                https://tailwindcss.com/docs/plugins
    |-----------------------------------------------------------------------------
    |
    | Here is where you can register any plugins you'd like to use in your
    | project. Tailwind's built-in `container` plugin is enabled by default to
    | give you a Bootstrap-style responsive container component out of the box.
    |
    | Be sure to view the complete plugin documentation to learn more about how
    | the plugin system works.
    |
    */

    plugins: [
        require('glhd-tailwindcss-transitions')(),
        function ({e, addUtilities}) {
            let placements = [];

            const amountOfTiles = 7;

            for (let y = -1; y <= amountOfTiles; ++y) {
                for (let x = -1; x <= amountOfTiles; ++x) {
                    placements.push({
                        [`.place-${x}-${y}`]: {
                            transform: `translate(${x * 100}%, ${y * 100}%)`,
                        },
                    });
                }
            }

            addUtilities(placements);
        },
        function ({addUtilities}) {
            const rotation = {
                '.rotate-90': {
                    transform: 'rotate(90deg)',
                },
                '.rotate-180': {
                    transform: 'rotate(180deg)',
                },
                '.rotate-270': {
                    transform: 'rotate(270deg)',
                },
            };

            addUtilities(rotation);
        },
        function ({e, addUtilities}) {
            const transforms = {
                '.tilt-board': {
                    transform: 'translateY(0) rotateX(50deg)',
                },
                '.tilt-board-sm': {
                    transform: 'translateY(0) rotateX(30deg)',
                },
                '.tilt-board-md': {
                    transform: 'translateY(-60px) rotateX(50deg)',
                },
                '.pawn-start': {
                    transform: 'translateY(-150%) rotateX(50deg)',
                },
                '.pawn-start-sm': {
                    transform: 'translateY(-150%) rotateX(30deg)',
                },
                '.straighten-pawn': {
                    transform: 'translateY(-30%) rotateX(-50deg)',
                },
                '.move-up': {
                    transform: 'translateY(-150%)',
                },
                '.left-out': {
                    transform: 'translateX(-100%)',
                },
                '.right-out': {
                    transform: 'translateX(100%)',
                },
                '.translateX-0': {
                    transform: 'translateX(0)',
                },
                '.translate-0': {
                    transform: 'translate(0)',
                },
                '.size-board': {
                    width: '80vw',
                    height: '75vw',
                    maxWidth: '100%',
                    maxHeight: '39.816rem',
                },
                '.size-board.paused': {
                    maxHeight: '35.816rem',
                },
                '.move-mode': {
                    transform: 'scale(0.9)',
                },
                '.move-mode-sm': {
                    transform: 'scale(0.6)',
                },
                '.move-mode-md': {
                    transform: 'translateY(-12%) scale(0.6)',
                },
            };

            addUtilities(transforms, ['responsive']);
        },
        function ({addUtilities}) {
            const transformSpecifics = {
                '.filter-gray': {
                    filter: 'grayscale()',
                },
                '.pin-t .hide-card': {
                    transform: 'translateY(-50%)',
                },
                '.pin-b .hide-card': {
                    transform: 'translateY(50%)',
                },
                '.pin-t .turned-card': {
                    transform: 'translateY(10%)',
                },
                '.pin-b .turned-card': {
                    transform: 'translateY(-10%)',
                },
                '.pin-t .active-card': {
                    transform: 'translateY(85%)',
                },
                '.pin-b .active-card': {
                    transform: 'translateY(-85%)',
                },
                '.scale-0': {
                    transform: 'scale(0)',
                },
                '.scale-100': {
                    transform: 'scale(1)',
                },
                '.move-tl': {
                    transform: 'translate(-200%, -200%)',
                },
                '.move-bl': {
                    transform: 'translate(-200%, 200%)',
                },
                '.move-tr': {
                    transform: 'translate(200%, -200%)',
                },
                '.move-br': {
                    transform: 'translate(200%, 200%)',
                },
                '.perspective': {
                    perspective: '2000px',
                },
                '.preserve3d': {
                    transformStyle: 'preserve-3d',
                },
                '.origin-bottom': {
                    transformOrigin: 'bottom center',
                },
                '.focus-opacity-100:focus *': {
                    opacity: 1,
                }
            };

            addUtilities(transformSpecifics);
        },
        function ({addComponents}) {
            const tablecloth = {
                '.tablecloth': {
                    background: 'url(\'/storage/images/tablecloth2.png\') bottom',
                    '&::after': {
                        content: '""',
                        display: 'block',
                        position: 'absolute',
                        bottom: '0',
                        left: '0',
                        right: '0',
                        width: '100%',
                        height: '20%',
                        transformOrigin: 'bottom center',
                        transform: 'rotateX(90deg)',
                        background: 'url(\'/storage/images/tablecloth2.png\') 50%',
                    },
                },
            };

            addComponents(tablecloth);
        },
    ],

    /*
    |-----------------------------------------------------------------------------
    | Advanced Options         https://tailwindcss.com/docs/configuration#options
    |-----------------------------------------------------------------------------
    |
    | Here is where you can tweak advanced configuration options. We recommend
    | leaving these options alone unless you absolutely need to change them.
    |
    */

    options: {
        prefix: "",
        important: false,
        separator: ":"
    }
};

/* eslint-disable quotes */

import { createTheme } from '@mui/material/styles';

const COLORS = {
    grayScale: {
        white: '#fff',
        gray: {
            100: '#f7f7f7',
            200: '#e9ecef',
            300: '#dee2e6',
            400: '#ced4da',
            500: '#adb5bd',
            600: '#6c757d',
            700: '#5E5E5E',
            800: '#404040',
            900: '#212529',
        },
        black: '#000',
    },
    main: {
        green: '#6DC003', // '#93D398',
        teal: '#12BAC5', // '#14B8A6',
        cyan: '#8dcee6',
        'vibrant-blue': '#0B65ED',
        blue: '#28337A',
        purple: '#4557a6',
        indigo: '#7f3c87',
        pink: '#ca6ba5',
        red: '#DC2626',
        orange: '#F58B3B',
        yellow: '#ffc107',
        peach: '#E97D67',
    },
    light: {
        green: '#E1EAA4',
        teal: '#CCFBF1',
        cyan: '#8dcee6',
        blue: '#4144ad',
        purple: '#8b98d1',
        indigo: '#94539B',
        pink: '#de8498',
        red: '#FEE2E2',
        orange: '#F8B55E',
        yellow: '#FADE80', // '#fbdd81',
    },
    dark: {
        green: '#18B463', // '#45BB8B',
        teal: '#134E4A',
        cyan: '#0dcaf0',
        blue: '#2c2f7a',
        purple: '#7174b5',
        indigo: '#4c2a50',
        pink: '#BE5F94',
        red: '#EF4444',
        orange: '#813709',
        yellow: '#ffc107',
    },
    low: {
        green: 'rgba(147, 211, 152, .15)',
        cyan: 'rgba(141, 206, 230, 0.15)',
        blue: 'rgba(44, 47, 122, 0.15)',
        indigo: 'rgba(127, 60, 135, 0.15)',
        purple: 'rgba(148, 83, 155, 0.15)',
        pink: 'rgba(222, 132, 152, 0.15)',
        orange: 'rgba(244, 122, 47, 0.15)',
        yellow: 'rgba(251, 221, 129, 0.15)',
    },
    medium: { blue: 'rgba(44, 47, 122, 0.5)' },
    schemes: {
        sunset: {
            orange: '#f27121',
            pink: '#e94057',
            purple: '#8a2387',
        },
    },
    info: {
        main: '#7FA1CE',
        light: '#8DCEE6',
        dark: '#7174B5',
        contrastText: '#7174B5',
    },
    success: {
        main: '#93D398',
        light: '#E1EAA4',
        dark: '#45BB8B',
        contrastText: '#45BB8B',
    },
    warning: {
        main: '#F8B55E',
        light: '#FADE80',
        dark: '#F58B3B',
        contrastText: '#F58B3B',
    },
    error: {
        main: '#D46E7E',
        light: '#E97D67',
        dark: '#BE5F94',
        contrastText: '#BE5F94',
    },
};

const PALETTE = {
    common: COLORS.grayScale,
    background: {
        default: COLORS.grayScale['100'],
        paper: COLORS.grayScale.white,
    },
    primary: {
        main: COLORS.main.blue,
        light: COLORS.light.blue,
        dark: COLORS.dark.blue,
        contrastText: COLORS.grayScale.white,
    },
    secondary: {
        main: COLORS.main.pink,
        light: COLORS.light.pink,
        dark: COLORS.dark.pink,
        contrastText: COLORS.grayScale.white,
    },
    /* ========================== COLORS ========================== */
    yellow: {
        main: COLORS.main.yellow,
        light: COLORS.light.yellow,
        dark: COLORS.dark.yellow,
        contrastText: COLORS.grayScale.white,
    },
    'vibrant-blue': {
        main: COLORS.main['vibrant-blue'],
        light: COLORS.light['vibrant-blue'],
        dark: COLORS.dark['vibrant-blue'],
        contrastText: COLORS.grayScale.white,
    },
    blue: {
        main: COLORS.main.blue,
        light: COLORS.light.blue,
        dark: COLORS.dark.blue,
        contrastText: COLORS.grayScale.white,
    },
    green: {
        main: COLORS.main.green,
        light: COLORS.light.green,
        dark: COLORS.dark.green,
        contrastText: COLORS.grayScale.white,
    },
    teal: {
        main: COLORS.main.teal,
        light: COLORS.light.teal,
        dark: COLORS.dark.teal,
        contrastText: COLORS.grayScale.white,
    },
    cyan: {
        main: COLORS.main.cyan,
        light: COLORS.light.cyan,
        dark: COLORS.dark.cyan,
        contrastText: COLORS.grayScale.white,
    },
    purple: {
        main: COLORS.main.purple,
        light: COLORS.light.purple,
        dark: COLORS.dark.purple,
        contrastText: COLORS.grayScale.white,
    },
    gradientCyan: {
        main: COLORS.main.cyan,
        light: COLORS.light.cyan,
        dark: COLORS.dark.cyan,
        contrastText: COLORS.grayScale.white,
    },
    gradientPurple: {
        main: COLORS.main.purple,
        light: COLORS.light.purple,
        dark: COLORS.dark.purple,
        contrastText: COLORS.grayScale.white,
    },
    gradientPink: {
        main: COLORS.main.pink,
        light: COLORS.light.pink,
        dark: COLORS.dark.pink,
        contrastText: COLORS.grayScale.white,
    },
    /* ============================================================ */
    info: COLORS.info,
    success: COLORS.success,
    warning: COLORS.warning,
    error: COLORS.error,
    text: {
        // primary: COLORS.main.blue,
        // secondary: COLORS.main.pink,
        gray: COLORS.grayScale.gray['700'],
        disabled: COLORS.grayScale.gray['500'],
    },
    other: {
        low: COLORS.low,
        medium: COLORS.medium,
        gradient: {
            /**
             * default degree: 172.5deg
             * alter degree: 135deg
             */
            green: `linear-gradient(135deg, ${COLORS.light.green} 0%, ${COLORS.dark.green} 102.6%)`,
            // teal: `linear-gradient(135deg, ${ } 0%, ${ } 102.6%)`,
            cyan: `linear-gradient(135deg, ${COLORS.main.cyan} 0%, ${COLORS.dark.purple} 102.6%)`,
            blue: `linear-gradient(135deg, ${COLORS.dark.blue} 0%, ${COLORS.main.cyan} 102.6%)`,
            indigo: `linear-gradient(135deg, ${COLORS.main.purple} 0%, ${COLORS.main.indigo} 102.6%)`,
            purple: `linear-gradient(135deg, ${COLORS.dark.pink} 0%, ${COLORS.main.purple} 102.6%)`,
            pink: `linear-gradient(135deg, ${COLORS.light.pink} 0%, ${COLORS.main.pink} 102.6%)`,
            orange: `linear-gradient(135deg, ${COLORS.main.peach} 0%, ${COLORS.dark.pink} 102.6%)`,
            yellow: `linear-gradient(135deg, ${COLORS.light.yellow} 0%, ${COLORS.main.orange} 100.8%)`,
        },
        scheme_gradient: {
            sunrise: `linear-gradient(225deg, ${COLORS.schemes.sunset.orange} 0%, ${COLORS.schemes.sunset.pink} 50%, ${COLORS.schemes.sunset.purple} 100%)`,
            sunset: `linear-gradient(135deg, ${COLORS.schemes.sunset.orange} 0%, ${COLORS.schemes.sunset.pink} 50%, ${COLORS.schemes.sunset.purple} 100%)`,
        },
    },
    action: {
        hover: COLORS.grayScale.gray['500'],
        focus: COLORS.grayScale.gray['300'],
    },
};

const AppTheme = createTheme({
    // spacing: (val) => {

    // },
    components: {
        // MUI
        MuiAppBar: {
            styleOverrides: {
                root: {
                    background: 'transparent',
                    color: PALETTE.primary.main,
                    border: 'none',
                    boxShadow: 'none',
                },
            },
            variants: [
                {
                    props: { variant: 'footer' },
                    style: {
                        flexDirection: 'row',
                        top: 'auto',
                        bottom: 0,
                        padding: '0 15px',
                        color: `${PALETTE.common.white} !important`,
                        background: PALETTE.primary.main,
                        borderRadius: 0,
                    },
                },
            ],
        },
        MuiAvatar: {
            styleOverrides: { root: { background: 'transparent' } },
            // variants: [

            // ],
        },
        MuiGrid: {
            styleOverrides: { root: {} },
            variants: [
                {
                    props: { variant: 'active-filters' },
                    style: {
                        padding: '16px 0',
                        borderBottom: '2px dashed #5E5E5E80',
                        '& .title': {
                            minWidth: 87.5,
                            // minHeight: 34,
                            marginRight: 24,
                            fontSize: 30,
                            color: PALETTE.text.gray,
                        },
                        '& .filter-icon': {
                            alignSelf: 'center',
                            // width: 34,
                            height: 34,
                            marginRight: 19,
                        },
                        '& .filter-name': {},
                    },
                },
            ],
        },
        MuiStack: {
            // styleOverrides: {
            //     root: {

            //     }
            // },
            variants: [
                {
                    props: { variant: 'auth-inputs' },
                    style: {
                        display: 'flex',
                        flexWrap: 'wrap',
                        alignItems: 'center',
                        width: '100%',
                    },
                },
                {
                    props: { variant: 'auth-button' },
                    style: {
                        minWidth: 177,
                        height: 58,
                        background: 'transparent',
                        border: `1px solid ${COLORS.main.pink}`,
                        borderRadius: '8px',
                        '& button': {
                            margin: '3px',
                            color: PALETTE.common.white,
                            fontSize: '20px',
                            fontWeight: 900,
                            fontStyle: 'italic',
                            background: PALETTE.other.gradient.purple,
                            borderRadius: '5px',
                        },
                    },
                },
                {
                    props: { variant: 'auth-footer' },
                    style: {
                        position: 'absolute',
                        bottom: 0,
                        width: '100%',
                        marginBottom: '16px',
                        '& *': {
                            fontSize: '16px',
                            lineHeight: '100%',
                        },
                    },
                },
                {
                    props: { variant: 'widget-v1' },
                    style: {
                        height: '100%',
                        '& .title': {
                            margin: '12px 12px 24px', // '24px 24px 32px',
                            color: PALETTE.primary.main,
                            letterSpacing: .8,
                        },
                        '& .description': {
                            margin: '0 12px 27px 12px',
                            color: PALETTE.primary.main,
                            fontFamily: 'Nunito Sans',
                            fontSize: 16,
                            fontWeight: 700,
                            lineHeight: '20px',
                        },
                        '& .no-wgt-msg': {
                            color: PALETTE.text.gray,
                            textAlign: 'center',
                            margin: '0 6px 8px',
                        },
                    },
                },
            ],
        },
        MuiPaper: {
            styleOverrides: {
                root: {
                    padding: 7,
                    borderRadius: 10,
                    boxShadow: '0px 3px 3px rgba(0, 0, 0, 0.15)',
                    '& *': {
                        // color: PALETTE.primary.main,
                    },
                },
            },
            variants: [
                {
                    props: { variant: 'auth-form' },
                    style: {
                        position: 'relative',
                        minHeight: 250,
                        borderRadius: '13px',
                    },
                },
                {
                    props: { color: 'light-indigo' },
                    style: {
                        background: COLORS.light.indigo,
                        '& *': { color: PALETTE.common.white },
                    },
                },
                {
                    props: { color: 'gradient-orange' },
                    style: {
                        background: PALETTE.other.gradient.orange,
                        '& *': { color: PALETTE.common.white },
                    },
                },
                {
                    props: { color: 'gradient-pink' },
                    style: {
                        background: PALETTE.other.gradient.pink,
                        '& *': { color: PALETTE.common.white },
                    },
                },
                {
                    props: { color: 'gradient-cyan' },
                    style: {
                        background: PALETTE.other.gradient.cyan,
                        '& *': { color: PALETTE.common.white },
                    },
                },
                {
                    props: { color: 'gradient-purple' },
                    style: {
                        background: PALETTE.other.gradient.purple,
                        '& *': { color: PALETTE.common.white },
                    },
                },
            ],
        },
        MuiMenu: {
            styleOverrides: {
                root: {
                    '& .MuiList-root': {
                        padding: '3px 0',
                        '& #popMenu-list': {
                            minWidth: 180,
                            padding: 0,
                            '& *': {
                                fontSize: 19,
                                color: `${PALETTE.common.gray['700']} !important`,
                            },
                            // '& li': {

                            // }
                        },
                    },
                },
            },
            // variants: [

            // ]
        },
        MuiMenuItem: { styleOverrides: { root: { color: PALETTE.primary.main } } },
        MuiFormControlLabel: {
            styleOverrides: {
                root: {
                    '& svg > path': { color: PALETTE.primary.main },
                    '& .MuiTypography-root': {
                        marginTop: '1.5px',
                        color: PALETTE.primary.main,
                        fontSize: '20px',
                        fontWeight: 700,
                        lineHeight: '100%',
                    },
                },
            },
            // variants: [

            // ]
        },
        MuiTypography: {
            // styleOverrides: {
            //     root: {

            //     }
            // },
            variants: [
                {
                    props: { variant: 'nav-listItemButton' },
                    style: {
                        paddingLeft: '8px',
                        fontFamily: 'Prompt',
                        fontWeight: 500,
                        fontSize: 19,
                        lineHeight: '100%',
                    },
                },
                {
                    props: { variant: 'subtitle-1' },
                    style: {
                        fontFamily: 'Nunito Sans',
                        fontWeight: 400,
                        fontSize: 14,
                        lineHeight: '100%',
                        color: PALETTE.text.gray,
                    },
                },
                {
                    props: { variant: 'tableCell-1' },
                    style: {
                        fontWeight: 600,
                        fontSize: 16,
                    },
                },
                {
                    props: { variant: 'tableCell-2' },
                    style: {
                        fontWeight: 500,
                        fontSize: 13,
                    },
                },
                {
                    props: { variant: 'tableCell-3' },
                    style: {
                        fontWeight: 500,
                        fontSize: 17,
                    },
                },
                {
                    props: { variant: 'selection-list-btn' },
                    style: {
                        marginRight: 16,
                        fontFamily: 'Nunito Sans',
                        fontSize: 19, // '30px',
                        fontWeight: 700, // 900,
                        // lineHeight: '100%',
                    },
                },
                {
                    props: { variant: 'selection-list-opt-txt' },
                    style: {
                        fontFamily: 'Nunito Sans',
                        fontSize: '22px', // '25px',
                        fontWeight: 800,
                        fontStyle: 'italic',
                        color: PALETTE.primary.main,
                    },
                },
            ],
        },
        MuiTextField: {
            styleOverrides: {
                root: {
                    '&.auth-form-input': {
                        width: '100%',
                        '& .MuiInputBase-root': {
                            borderRadius: '5px !important',
                            '& .MuiInputBase-input': {
                                height: '20px',
                                color: `${PALETTE.primary.main} !important`,
                                fontSize: '24px',
                                fontWeight: 700,
                                lineHeight: '100%',
                                border: `1px solid ${PALETTE.primary.main}`,
                                borderRadius: '5px',
                            },
                        },
                    },
                    '&:disabled': { color: PALETTE.text.disabled },
                },
            },
            // variants: [

            // ]
        },
        MuiInput: { styleOverrides: { root: { '&:disabled': { color: PALETTE.text.disabled } } } },
        MuiButton: {
            styleOverrides: {
                root: {
                    // sizing
                    minWidth: 80,
                    minHeight: 50,
                    padding: '6px 12px',
                    // typography
                    fontFamily: 'Prompt',
                    fontWeight: 500,
                    fontSize: 19,
                    lineHeight: '100%',
                    color: PALETTE.primary.main,
                    background: 'transparent',
                    // body
                    borderRadius: '10px',
                    '& *': { transition: '.275s ease' },
                    // '&:hover': {

                    // },
                    '&:disabled': {
                        color: `${PALETTE.text.disabled} !important`,
                        background: 'transparent !important',
                        border: `1px solid ${PALETTE.common.gray['500']} !important`,
                    },
                    transition: '.3s ease',
                },
            },
            variants: [
                {
                    props: { variant: 'text' },
                    style: {
                        background: 'transparent',
                        border: 'none',
                        boxShadow: 'none',
                        '&.selection-list-opt-btn': {
                            minHeight: '100%',
                            padding: '8px 36px 6px',
                            '&:hover': {
                                background: `${PALETTE.common.gray['200']} !important`,
                                boxShadow: '0px 3px 3px rgba(0, 0, 0, 0.15) !important',
                            },
                        },
                    },
                },
                {
                    props: { variant: 'outlined' },
                    style: {
                        color: PALETTE.primary.main,
                        border: `1.5px solid ${PALETTE.primary.main}`,
                    },
                },
                {
                    props: { variant: 'outlined', color: 'error' },
                    style: {
                        color: COLORS.main.peach,
                        border: `1.5px solid ${COLORS.error.light}`,
                    },
                },
                {
                    props: { variant: 'contained' },
                    style: {
                        color: PALETTE.common.white,
                        boxShadow: '0px 3px 3px rgba(0, 0, 0, 0.15)',
                        '&.selection-list-btn': {
                            height: '80px', // '132px',
                            padding: '16px 32px', // '34px 42px',
                        },
                    },
                },
                {
                    props: { variant: 'contained', color: 'success' },
                    style: { background: PALETTE.other.gradient.green },
                },
                {
                    props: { variant: 'contained', color: 'gradientCyan' },
                    style: { background: PALETTE.other.gradient.cyan },
                },
                {
                    props: { variant: 'contained', color: 'gradientPurple' },
                    style: { background: PALETTE.other.gradient.purple },
                },
                {
                    props: { variant: 'contained', color: 'gradientPink' },
                    style: { background: PALETTE.other.gradient.pink },
                },
                {
                    props: { variant: 'avatar' },
                    style: {
                        minWidth: 40,
                        minHeight: 40,
                        padding: 0,
                        borderRadius: '50%',
                        // '& .MuiTouchRipple-root': {

                        // },
                        '&:hover': { background: PALETTE.other.low.cyan },
                    },
                },
                {
                    props: { variant: 'link' },
                    style: {
                        color: PALETTE.text.gray,
                        background: 'none',
                        border: 'none',
                        textDecoration: 'underline !important',
                    },
                },
            ],
        },
        MuiPaginationItem: {
            styleOverrides: {
                root: {
                    color: PALETTE.common.white,
                    background: PALETTE.other.gradient.purple,
                    '&.Mui-selected': { color: COLORS.main.pink },
                },
            },
        },
        MuiAutocomplete: {
            styleOverrides: {
                root: {
                    marginBottom: 13,
                    borderRadius: 8,
                    '&.Mui-focused': {
                        '& .MuiInputLabel-root': {
                            marginTop: '-1px',
                            lineHeight: '120%',
                        },
                    },
                    '& .MuiInputLabel-root': {
                        marginTop: '-1.25px',
                        fontFamily: 'Nunito Sans',
                        fontWeight: 600,
                        fontSize: 20,
                        lineHeight: '100%',
                        color: PALETTE.text.gray,
                    },
                    '& fieldset': { borderColor: 'transparent' },
                },
            },
            variants: [
                {
                    props: { variant: 'nav-filter', color: 'cyan' },
                    style: {
                        '&.Mui-focused': { '& fieldset': { borderColor: `${PALETTE.primary.main} !important` } },
                        '& .MuiInputLabel-root': { color: PALETTE.primary.main },
                        '& .MuiChip-root': { background: PALETTE.primary.main },
                    },
                },
                {
                    props: { variant: 'nav-filter', color: 'orange' },
                    style: {
                        '&.Mui-focused': { '& fieldset': { borderColor: `${COLORS.main.orange} !important` } },
                        '& .MuiInputLabel-root': { color: COLORS.dark.orange },
                        '& .MuiChip-root': { background: COLORS.main.orange },
                    },
                },
            ],
        },
        MuiList: {
            styleOverrides: {
                root: {
                    padding: '7px 21px',
                    // color: PALETTE.primary.main,
                    background: PALETTE.common.white,
                    borderRadius: '13px',
                },
            },
            variants: [
                {
                    props: { variant: 'selection-list' },
                    style: {
                        maxHeight: '330px',
                        padding: '18px 12px', // '22px 26.5px',
                        borderRadius: '0 0 13px 13px',
                        boxShadow: '0px 3px 3px rgba(0, 0, 0, 0.15)',
                        overflowY: 'auto',
                    },
                },
            ],
        },
        MuiListItem: {
            // styleOverrides: {
            //     root: {

            //     }
            // },
            variants: [
                {
                    props: { variant: 'selection-list-opt' },
                    style: {
                        height: '40px',
                        padding: 0,
                        marginBottom: '3px',
                    },
                },
            ],
        },
        MuiListSubheader: {
            // styleOverrides: {
            //     root: {

            //     }
            // },
            variants: [
                {
                    props: { variant: 'nav-menu' },
                    style: {
                        padding: '0 7px 10px',
                        color: PALETTE.primary.main,
                        fontFamily: 'Nunito Sans',
                        fontWeight: 800,
                        fontSize: 22,
                        lineHeight: '100%',
                    },
                },
            ],
        },
        MuiListItemButton: {
            styleOverrides: {
                root: {
                    // sizing
                    height: '54px',
                    p: '11px 22px',
                    // body
                    color: PALETTE.common.gray['700'], // AQUI USAR CONST 'COLORS' --> por algum motivo, ele recebe undefined se puxar da PALETTE
                    background: 'transparent',
                    border: 'none',
                    borderRadius: '10px',
                    '&.Mui-selected': {
                        color: `${PALETTE.common.white} !important`,
                        '& .MuiListItemIcon-root': { filter: 'invert(100%) sepia(0%) saturate(7500%) hue-rotate(10deg) brightness(150%) contrast(300%)' },
                    },
                    '&:hover': {
                        color: `${PALETTE.common.white} !important`,
                        '& .MuiListItemIcon-root': { filter: 'invert(100%) sepia(0%) saturate(7500%) hue-rotate(10deg) brightness(150%) contrast(300%)' },
                    },
                    transition: '.2s ease',
                },
            },
            variants: [
                {
                    props: { variant: 'text', color: 'pink' },
                    style: {
                        '&.Mui-selected': { background: `${PALETTE.other.gradient.indigo} !important` },
                        '&:hover': { background: `${PALETTE.other.gradient.pink} !important` },
                    },
                },
                {
                    props: { variant: 'text', color: 'cyan' },
                    style: {
                        '&.Mui-selected': { background: `${PALETTE.other.gradient.blue} !important` },
                        '&:hover': { background: `${PALETTE.other.gradient.cyan} !important` },
                    },
                },
                {
                    props: { variant: 'text', color: 'purple' },
                    style: {
                        '&.Mui-selected': { background: `${PALETTE.other.gradient.pink} !important` },
                        '&:hover': { background: `${PALETTE.other.gradient.purple} !important` },
                    },
                },
            ],
        },
        MuiTableContainer: {
            styleOverrides: {
                root: {
                    width: 'auto',
                    margin: '10px 0 0',
                    padding: '10px 10px 22px',
                    background: PALETTE.common.white,
                    borderRadius: 10,
                    boxShadow: '0px 3px 3px rgba(0, 0, 0, 0.15)',
                    // '& *': {
                    //     // color: PALETTE.primary.main,
                    // }
                },
            },
            variants: [
                {
                    props: { variant: 'no-bg' },
                    style: {
                        background: 'transparent',
                        boxShadow: 'none',
                    },
                },
            ],
        },
        // MuiTableRow: {
        //     styleOverrides: {
        //         root: {

        //         }
        //     },
        //     variants: [

        //     ],
        // },
        MuiTableCell: {
            styleOverrides: {
                root: {
                    fontFamily: 'Nunito Sans',
                    lineHeight: '100%',
                    color: COLORS.grayScale.gray['800'],
                },
            },
            variants: [
                {
                    props: { variant: 'button' },
                    style: {
                        width: '3.75% !important',
                        padding: 0,
                        '& button': { minWidth: '100%' },
                    },
                },
                {
                    props: { variant: 'button', color: 'error' },
                    style: { '& button': { color: `${PALETTE.error.main} !important` } },
                },
                {
                    props: { variant: 'button', color: 'success' },
                    style: { '& button': { color: `${PALETTE.success.dark} !important` } },
                },
                {
                    props: { variant: 'button', color: 'info' },
                    style: { '& button': { color: `${PALETTE.info.main} !important` } },
                },
                {
                    props: { variant: 'pagination' },
                    style: {
                        border: 'none',
                        padding: '0 34px 0 16px',
                    },
                },
            ],
        },
        MuiDivider: {
            // styleOverrides: {
            //     root: {

            //     }
            // },
            variants: [
                {
                    props: { variant: 'no-deco' },
                    style: {
                        background: 'transparent',
                        border: 'none',
                    },
                },
            ],
        },
        MuiStepLabel: {
            styleOverrides: {
                root: {
                    '& .MuiStepLabel-label': {
                        fontFamily: 'Nunito Sans',
                        fontSize: '15px',
                        fontWeight: 500,
                        lineHeight: '100%',
                        color: PALETTE.text.disabled,
                        '&.Mui-active': {
                            fontSize: '18px',
                            fontWeight: 700,
                            color: PALETTE.primary.main,
                        },
                        '&.Mui-completed': { color: PALETTE.other.medium.blue },
                    },
                },
            },
        },
        // Custom
        Sidebar: {
            border: 'none',
            '.ps-sidebar-container': {
                height: 'unset',
                background: 'transparent',
            },
        },
        NavBar: {
            height: '100vh',
            padding: '46px 23px 0 18px',
            background: PALETTE.background.default,
        },
        MainView: {
            background: PALETTE.background.default,
            borderLeft: '2px dashed #5E5E5E80',
        },
        SearchInput: {
            color: PALETTE.common.gray['700'],
            background: PALETTE.common.gray['200'],
            border: `1px solid ${PALETTE.common.gray['700']}`,
            borderRadius: '8px',
            boxShadow: 'none',
        },
    },
    shape: { borderRadius: 10 },
    // mixins: {

    // },
    customized: {
        layout: {
            flex: {
                row: { flexDirection: 'row' },
                column: { flexDirection: 'column' },
                AStart_JBetween: {
                    display: 'flex',
                    alignItems: 'start',
                    justifyContent: 'space-between',
                },
                ACenter_JStart: {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'start',
                },
                ACenter_JCenter: {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                },
                ACenter_JAround: {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'space-around',
                },
                ACenter_JBetween: {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'space-between',
                },
                ACenter_JEvenly: {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'space-evenly',
                },
                ACenter_JEnd: {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'end',
                },
                AEnd_JBetween: {
                    display: 'flex',
                    alignItems: 'end',
                    justifyContent: 'space-between',
                },
            },
            rotate: {
                45: { transform: 'rotate(45deg)' },
                90: { transform: 'rotate(90deg)' },
                135: { transform: 'rotate(135deg)' },
                180: { transform: 'rotate(180deg)' },
            },
            FilterFieldAutocomplete: {
                outerInput: {
                    background: '#ffffffb3',
                    variants: {
                        cyan: {},
                        orange: {},
                    },
                },
                innerInput: {
                    padding: '3px 6px !important',
                    fontFamily: 'Nunito Sans',
                    fontWeight: 600,
                    fontSize: 18,
                    color: PALETTE.text.gray,
                    variants: {
                        cyan: { color: PALETTE.primary.main },
                        orange: { color: COLORS.dark.orange },
                    },
                    '&:disabled': { color: `${PALETTE.text.disabled} !important` },
                },
            },
        },
        // shape: {

        // },
        // typography: {

        // },
    },
    palette: PALETTE,
    typography: {
        htmlFontSize: 19,
        fontFamily: 'Nunito',
        fontFamilies: {
            nunito: 'Nunito Sans',
            prompt: 'Prompt',
        },
        fontSize: 16,
        fontWeightLight: 300,
        fontWeightRegular: 500,
        fontWeightMedium: 600,
        fontWeightBold: 700,
        fontWeightBolder: 900,
        h1: {
            fontFamily: 'Prompt',
            fontWeight: 500,
            fontSize: 30,
            lineHeight: '100%',
        },
        h2: {
            fontFamily: 'Nunito Sans',
            fontWeight: 700,
            fontSize: 22,
            lineHeight: '100%',
        },
        h3: {
            fontFamily: 'Nunito Sans',
            fontWeight: 800,
            fontSize: 18,
            lineHeight: '100%',
        },
        body1: {
            fontFamily: 'Nunito Sans',
            fontWeight: 300,
            fontSize: 20,
            lineHeight: '100%',
            color: PALETTE.common.gray['800'],
        },
        body2: {
            fontFamily: 'Prompt',
            fontWeight: 500,
            fontSize: 19,
            lineHeight: '100%',
            color: PALETTE.primary.main,
        },
        button1: {
            fontFamily: 'Prompt',
            fontWeight: 500,
            fontSize: 19,
            lineHeight: '100%',
            color: PALETTE.text.gray,
        },
        button2: {
            fontFamily: 'Nunito Sans',
            fontWeight: 600,
            fontSize: 16,
            lineHeight: '100%',
            color: PALETTE.text.gray,
        },
        footer: {
            fontFamily: 'Nunito Sans',
            fontWeight: 300,
            fontSize: 20,
            lineHeight: '100%',
            color: PALETTE.common.white,
        },
    },
});

export default AppTheme;

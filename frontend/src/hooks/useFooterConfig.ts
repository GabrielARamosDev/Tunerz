import { useMediaQuery } from 'react-responsive';
import useWindowHeight from './useWindowHeight';

const FOOTER_BAR_HEIGHT = 38;
const FOOTER_BAR_HEIGHT_MOBILE = 31;

export default () => {
    const isTablet = useMediaQuery({ query: '(min-width: 768px)' });
    const windowHeight = useWindowHeight();

    const footerBarHeight = isTablet ? FOOTER_BAR_HEIGHT : FOOTER_BAR_HEIGHT_MOBILE;
    const footerWindowDiff = windowHeight - footerBarHeight;

    return {
        footerBarHeight,
        footerWindowDiff,
    };
};


import '@mui/material/Divider';

declare module '@mui/material/Divider' {
  interface DividerPropsVariantOverrides {
    'no-deco': true;
  }
}

import '@mui/material/Typography';

declare module '@mui/material/Typography' {
  interface TypographyPropsVariantOverrides {
    'nav-listItemButton': true;
    'subtitle-1': true;
    'tableCell-1': true;
    'tableCell-2': true;
    'tableCell-3': true;
  }
}

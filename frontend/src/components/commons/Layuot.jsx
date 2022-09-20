import {Divider, Grid, Typography} from "@mui/material";

const Layout = ({children, title}) =>
  (
    <div style={{padding: '2em'}}>
      <Typography variant="h5">{title}</Typography>
      <Divider/>
      <Grid container spacing={2} sx={{mt: 1}}>
        {children}
      </Grid>
    </div>
  );

export default Layout;
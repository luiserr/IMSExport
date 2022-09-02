import {Box, Button, Grid, TextField} from "@mui/material";

const Export = () => {
  return (
    <>
      <Grid item xs={4}>
        <Box
          component="form"
          noValidate
          autoComplete="off"
        >
          <TextField fullWidth id="id" label="Id de semilla" variant="outlined"/>
        </Box>
      </Grid>
      <Grid item xs={3}>
        <Button variant="outlined">Buscar</Button>
      </Grid>
    </>
  );
}

export default Export;
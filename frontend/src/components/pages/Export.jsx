import {Box, Button, Grid, TextField} from "@mui/material";
import {get} from "../../utils/request";
import {useState} from "react";

const Export = () => {

  const [seedId, setSeedId] = useState('');

  const handleSearch = async () => {
    const response = await get(`export/${seedId}`);
    alert(response.message);
  };

  return (
    <>
      <Grid item xs={4}>
        <Box
          component="form"
          noValidate
          autoComplete="off"
        >
          <TextField
            fullWidth
            id="id"
            label="Id de semilla"
            variant="outlined"
            onChange={(e)=> {
              setSeedId(e.target.value);
            }}
          />
        </Box>
      </Grid>
      <Grid item xs={3}>
        <Button variant="outlined" onClick={handleSearch}>Exportar</Button>
      </Grid>
    </>
  );
}

export default Export;
import {Box, Button, FormControl, Grid, InputLabel, MenuItem, Select, TextField} from "@mui/material";
import {get} from "../../utils/request";
import {useState} from "react";
import ConfigSearch from "../Export/ConfigSearch";
import useSearch from "../Export/searchHook";

const Export = () => {

  const [seedId, setSeedId] = useState('');
  const [sourceType, setSourceType] = useState('simple');
  const [payload, setPayload] = useState(null);

  const component = useSearch(sourceType, payload, setPayload);

  const handleSearch = async () => {
    const response = await get(`export/${seedId}`);
    alert(response.message);
  };

  return (
    <>
      <ConfigSearch
        seedId={seedId}
        setSeedId={setSeedId}
        sourceType={sourceType}
        setSourceType={setSourceType}
      />
      {
        component
      }
      <Grid item xs={3}>
        <Button variant="outlined" onClick={handleSearch}>Exportar</Button>
      </Grid>
    </>
  );
}

export default Export;
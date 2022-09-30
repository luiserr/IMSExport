import {FormControl, Grid, InputLabel, MenuItem, Select} from "@mui/material";
import {useState} from "react";

const ConfigSearch = (
  {
    typeId,
    setTypeId,
    sourceType,
    setSourceType
  }
) => {

  const [disable, setDisable] = useState(sourceType === 'name');

  const handleChangeSource = (value) => {
    setSourceType(value);
    if (value === 'name') {
      setDisable(true);
      return setTypeId('groupId');
    }
    setDisable(false)
    setTypeId('');
  }

  return (
    <>
      <Grid item xs={6}>
        <FormControl fullWidth>
          <InputLabel id="label-type-search">Tipo de búsqueda</InputLabel>
          <Select
            labelId="label-type-search"
            value={sourceType}
            label="Tipo de búsqueda"
            onChange={(e) => handleChangeSource(e.target.value)}
          >
            <MenuItem value="simple">Digitar ID</MenuItem>
            <MenuItem value="csv">Cargar CSV</MenuItem>
            <MenuItem value="name">Búsqueda por nombre</MenuItem>
          </Select>
        </FormControl>
      </Grid>
      <Grid item xs={6}>
        <FormControl fullWidth>
          <InputLabel id="label-seedId">Buscar por:</InputLabel>
          <Select
            labelId="label-seedId"
            value={typeId}
            disabled={disable}
            label="Buscar por:"
            onChange={(e) => setTypeId(e.target.value)}
          >
            <MenuItem value="seedId">Id de semilla</MenuItem>
            <MenuItem value="groupId">Id de grupo</MenuItem>
          </Select>
        </FormControl>
      </Grid>
    </>
  );
}

export default ConfigSearch;
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
          <InputLabel id="label-seedId">Indice a usar: </InputLabel>
          <Select
            labelId="label-seedId"
            value={typeId}
            disabled={disable}
            label="Buscar por:"
            onChange={(e) => setTypeId(e.target.value)}
          >
            <MenuItem value="groupId">Id primario <i>(Id primario de la tabla de cursos)</i></MenuItem>
            <MenuItem value="seedId">Código de semilla <i>(Ej: 12310175_1_VIRTUAL_2)</i></MenuItem>
          </Select>
        </FormControl>
      </Grid>
    </>
  );
}

export default ConfigSearch;
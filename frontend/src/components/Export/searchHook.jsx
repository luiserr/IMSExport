import CSVReader from "../commons/CSVReader";
import {myAlert} from "../../utils/alerts";
import {Box, Grid, TextField} from "@mui/material";
import {useEffect} from "react";
import SearchName from "./SearchName";

const useSearch = (sourceType, payload, setPayload) => {
  useEffect(() => {
    setPayload(null)
  }, [sourceType]);


  const handleReader = (rows = []) => {
    const groups = [];
    if (rows[0].length > 1000) {
      return myAlert('Ha excedido el límite máximo de cursos a exportar. El límite es 1000 cursos')
    }
    for (let i = 0; i < rows[0].length; i++) {
      if (!groups.find(group => group === rows[0][i])) {
        const groupId = rows[0][i];
        if (groupId !== '') {
          groups.push(groupId);
        }
      }
    }
    setPayload(groups);
  }


  if (sourceType === 'csv') {
    return (<Grid item xs={4}>
      <CSVReader handleReader={handleReader}/>
    </Grid>)
  }
  if (sourceType === 'name') {
    return <SearchName setPayload={setPayload}/>
  }
  return (<Grid item xs={4}>
    <Box
      component="form"
      noValidate
      autoComplete="off"
    >
      <TextField
        fullWidth
        id="id"
        label="Código de semilla"
        variant="outlined"
        value={payload}
        onChange={(e) => {
          setPayload(e.target.value);
        }}
      />
    </Box>
  </Grid>)
}

export default useSearch;
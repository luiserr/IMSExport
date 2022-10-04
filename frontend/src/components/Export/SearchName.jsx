import {Grid, TextField} from "@mui/material";
import {useState} from "react";
import {post} from "../../utils/request";
import TableGroups from "./TableGroups";
import {toast} from "../../utils/alerts";

const SearchName = ({setPayload}) => {

  const [groups, setGroups] = useState([]);


  const handleCheck = (id, checked) => {
    const onlyCheck = [];
    const newGroups = groups.map((group) => {
      if (group.id === id) {
        group.checked = checked;
      }
      if (group.checked) {
        onlyCheck.push(id);
      }
      return group;
    });
    setPayload(onlyCheck);
    setGroups(newGroups);
  }

  let debounceSearch = null;

  const fetchGroups = (e) => {
    const value = e.target.value;
    if (debounceSearch) {
      clearTimeout(debounceSearch);
    }
    debounceSearch = setTimeout(() => {
      if (!value) {
        setGroups([]);
        return null;
      }

      post(`api/assignQuestionnaires/groups`, {name: value, id: value, groupId: value})
        .then(response => {
          if (response.success && response.data) {
            return setGroups(response.data);
          }
          return setGroups([]);
        })
        .catch(() => {
          toast('No hay datos para mostrar', false)
        });
    }, 800);
  }

  return (
    <Grid item xs={12}>
      <Grid item xs={6}>
        <TextField
          fullWidth
          id="id"
          label="Digite nombre de curso a exportar"
          variant="outlined"
          onChange={
            (e) => fetchGroups(e)
          }
        />
      </Grid>
      <Grid item xs={12} sx={{mt: 1}}>
        <TableGroups groups={groups} setGroups={handleCheck}/>
      </Grid>
    </Grid>
  );
};

export default SearchName;
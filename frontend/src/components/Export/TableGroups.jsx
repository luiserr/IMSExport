import MyTable from "../commons/table";
import {Checkbox} from "@mui/material";

const headers = {
  'id': 'Id',
  'name': 'Nombre',
  'initDate': 'Fecha inicio',
  'finishDate': 'Fecha fin'
};

const TableGroups = ({groups, setGroups, setPayload}) => {

  const actions = [
    {
      title: 'Seleccionar',
      component: ({id, checked}) => (
        <Checkbox
          checked={checked}
          onChange={(e) => setGroups(id, e.target.checked)}
        />
      )
    }
  ];


  return (
    <>
      <h3>Resultado búsqueda de fichas</h3>
      <MyTable
        headers={headers}
        actions={actions}
        data={groups}
      />
    </>
  );
};

export default TableGroups;
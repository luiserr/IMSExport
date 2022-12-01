import MyTable from "../commons/table";
import {Button} from "@mui/material";
import {post} from "../../utils/request";
import DeleteIcon from '@mui/icons-material/Delete';

const headers = {
  'id': 'Id',
  'groupId': 'Id de curso',
  'name': 'Nombre del curso',
  'createdAt': 'Fecha de creación',
};

const Exports = ({exports, searchExports}) => {

  const handleDelete = async (id) => {
    await post('exportGroups/export', {id}, 'DELETE', false, true);
    await searchExports();
  };

  const actions = [
    {
      title: 'Eliminar',
      component: ({id}) => (
        <Button
          startIcon={<DeleteIcon/>}
          onClick={() => handleDelete(id)}
        />
      )
    }
  ];

  return (
    <>
      <h3>Exportaciones creadas</h3>
      <MyTable
        data={exports}
        headers={headers}
        actions={actions}
      />
    </>
  );
}

export default Exports;
import MyTable from "../commons/table";
import {Button} from "@mui/material";
import {post} from "../../utils/request";
import DeleteIcon from '@mui/icons-material/Delete';

const headers = {
  'groupId': 'Id de curso',
  'createdAt': 'Fecha de creación',
};

const Exports = ({exports, searchExports}) => {

  const handleDelete = async (id) => {
    await post('export', {id}, 'delete', false, true);
    await searchExports();
  };

  const actions = [
    {
      title: 'Eliminar',
      component: ({id}) => (
        <Button
          startIcon={<DeleteIcon />}
          onClick={() => handleDelete(id)}
        />
      )
    }
  ];

  return (<MyTable
    data={exports}
    headers={headers}
    actions={actions}
  />);
}

export default Exports;
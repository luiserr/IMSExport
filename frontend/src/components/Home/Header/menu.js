import CreateNewFolderIcon from '@mui/icons-material/CreateNewFolder';
import CloudSyncIcon from '@mui/icons-material/CloudSync';
import CloudDownloadIcon from '@mui/icons-material/CloudDownload';

const createMenu = (label, route, icon)=> ({
  label,
  route,
  icon
})

export default [
  createMenu('Crear exportación', '/admin/exports/', <CreateNewFolderIcon />),
  createMenu('Exportaciones en progreso', '/admin/exports/inProgress', <CloudSyncIcon />),
  createMenu('Exportación finalizadas', '/admin/exports/finished', <CloudDownloadIcon />),
];
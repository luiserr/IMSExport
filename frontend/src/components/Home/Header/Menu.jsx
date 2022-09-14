import {Divider, Drawer, List, ListItem, ListItemButton} from "@mui/material";
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import InboxIcon from '@mui/icons-material/MoveToInbox';
import MailIcon from '@mui/icons-material/Mail';
import Box from "@mui/material/Box";
import * as PropTypes from 'prop-types';

const Menu = ({show, setShow}) => {

  const list = () => (
    <Box
      role="presentation"
      onClick={() => setShow(false)}
      onKeyDown={() => setShow(false)}
    >
      <List>
        {['Exportar', 'En progreso'].map((text, index) => (
          <ListItem key={text} disablePadding>
            <ListItemButton>
              <ListItemIcon>
                {index % 2 === 0 ? <InboxIcon/> : <MailIcon/>}
              </ListItemIcon>
              <ListItemText primary={text}/>
            </ListItemButton>
          </ListItem>
        ))}
      </List>
      <Divider/>
      <List>
        {['Fallidos', 'Completados'].map((text, index) => (
          <ListItem key={text} disablePadding>
            <ListItemButton>
              <ListItemIcon>
                {index % 2 === 0 ? <InboxIcon/> : <MailIcon/>}
              </ListItemIcon>
              <ListItemText primary={text}/>
            </ListItemButton>
          </ListItem>
        ))}
      </List>
    </Box>
  );

  return (
    <div>
      <>
        <Drawer
          anchor="left"
          open={show}
          onClose={() => setShow(false)}
        >
          {list()}
        </Drawer>
      </>
    </div>
  );
}

Menu.propTypes = {
  show: PropTypes.bool,
  setShow: PropTypes.func,
};

export default Menu;
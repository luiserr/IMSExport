import {Divider, Drawer, List, ListItem, ListItemButton} from "@mui/material";
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import InboxIcon from '@mui/icons-material/MoveToInbox';
import MailIcon from '@mui/icons-material/Mail';
import Box from "@mui/material/Box";
import * as PropTypes from 'prop-types';
import {useNavigate} from "react-router-dom";

const Menu = ({show, setShow}) => {

  const navigate = useNavigate();

  const list = () => (
    <Box
      role="presentation"
      onClick={() => setShow(false)}
      onKeyDown={() => setShow(false)}
    >
      <List>

        <ListItem disablePadding>
          <ListItemButton>
            <ListItemIcon>
              <MailIcon/>
            </ListItemIcon>
            <ListItemText
              primary="Crear exportación"
              onClick={() => navigate('/')}
            />
          </ListItemButton>
        </ListItem>

      </List>
      <Divider/>
      <List>
        <ListItem disablePadding>
          <ListItemButton>
            <ListItemIcon>
              <InboxIcon/>
            </ListItemIcon>
            <ListItemText
              primary="Exportaciones en progreso"
              onClick={() => navigate('/inProgress')}
            />
          </ListItemButton>
        </ListItem>
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
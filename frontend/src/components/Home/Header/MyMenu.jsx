import {Box, Drawer, List, ListItem, ListItemButton} from "@mui/material";
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import * as PropTypes from 'prop-types';
import {useNavigate} from "react-router-dom";
import menu from "./menu";


const MyMenu = ({show, setShow}) => {

  const navigate = useNavigate();

  const list = () => (
    <Box
      role="presentation"
      onClick={() => setShow(false)}
      onKeyDown={() => setShow(false)}
    >
      <List>
        {
          menu.map(({label, route, icon}, index) => (
            <ListItem disablePadding key={index}>
              <ListItemButton>
                <ListItemIcon>
                  {icon}
                </ListItemIcon>
                <ListItemText
                  primary={label}
                  onClick={() => navigate(route)}
                />
              </ListItemButton>
            </ListItem>
          ))
        }
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

MyMenu.propTypes = {
  show: PropTypes.bool,
  setShow: PropTypes.func,
};

export default MyMenu;
import React from 'react';
import {Card, CardContent, Container, Grid} from "@mui/material";
import {Outlet} from 'react-router-dom';
import Header from "./Header";

const Body = () => {
  return (
    <>
      <Header/>
      <Container sx={{marginTop: '2em'}}>
        <Card elevation={3}>
          <CardContent>
            <Grid container spacing={2}>
              <Outlet/>
            </Grid>
          </CardContent>
        </Card>
      </Container>
    </>
  );
}

Body.propTypes = {};

export default Body;

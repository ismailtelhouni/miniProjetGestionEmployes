import { BrowserRouter as Router , Route ,Routes } from 'react-router-dom'
import React from 'react'


import './App.css'

import { Container } from './components'
import { Header ,Footer } from './Sections'
import { Home , Profile } from './Pages'

const App = () => {
    return(
        <>
            <Router>
                <Header />
                <Container >
                    <Routes>
                        <Route path='/' element={ <Home/> } />
                        <Route path='/profile' element={ <Profile/> } />
                    </Routes>
                </Container>
                <Footer />
            </Router>
        </>
    )
}
export default App
import React, { Component } from 'react';
import { BrowserRouter as Router, Route, Link } from "react-router-dom";

import CreateEntrega from "./pages/entregas/CreateEntrega";
import IndexEntrega from "./pages/entregas/IndexEntrega";
import AbrirEntrega from "./pages/entregas/AbrirEntrega";

export default class App extends Component {
    render() {
        return (
            <Router>
            <div>
                <nav className="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
                    <Link className="navbar-brand" to="/">App Unicad</Link>
                </nav>
                <main className="container-fluid">
                    <Route exact path="/" component={IndexEntrega} />
                    <Route path="/nova" component={CreateEntrega} />
                    <Route path="/abrir/:id" component={AbrirEntrega} />
                </main>
                <footer className="footer py-4">
                    <div className="container-fluid text-center">
                        <span className="text-muted">
                             &copy; Grupo Unicad | Todos os direitos reservados
                        </span>
                    </div>
                </footer>
            </div>
            </Router>
        );
    }
}

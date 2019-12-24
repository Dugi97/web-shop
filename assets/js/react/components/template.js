import React, {Component} from 'react';
import {connect} from 'react-redux';
import { fetchProjects } from "../actions";


class Homepage extends Component {
    
    constructor(props) {
        super(props)

        this.state = {
            name: []
        }
    }

    componentDidMount() {
        this.props.fetchProjects();
    }

    componentWillReceiveProps(nextProps) {
        this.setState({
            name: nextProps.projects,
        });
    }

    render() {

        return (
            <div>
                <h4>React Installed</h4>
            </div>
        )
    }
}

function mapStateToProps(state) {
    return {
        projects: state.projects,
    }
}

export default connect(mapStateToProps, { fetchProjects })(Homepage);
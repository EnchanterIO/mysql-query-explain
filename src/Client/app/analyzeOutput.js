import React from 'react';


class AnalyzeOutput extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <p>{this.props.queryMessages}</p>
        );
    }
}

export default AnalyzeOutput;

import React from 'react';
import Progress from './Progress'


class AnalyzeOutput extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const progress = this.props.messages.map((progress, id) => {
            return <Progress key={id} message={progress.message} stats={progress.stats} />
        });

        return (
            <div className="row">
                <div className="col explain_messages">
                    <h3>Analyze output:</h3>
                    <div>
                        {progress}
                    </div>
                </div>
            </div>
        );
    }
}

export default AnalyzeOutput;

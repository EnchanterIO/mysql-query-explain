import React from 'react';
import Progress from './Progress'


class AnalyzeOutput extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const progress = this.props.messages.map((progress, id) => {
            return <Progress isError={progress.isError} key={id} message={progress.message} rows={progress.rows} />
        });

        return (
            <div className="row">
                <div className="col explain_messages">
                    <h5>Analyze output:</h5>
                    <div>
                        {progress}
                    </div>
                </div>
            </div>
        );
    }
}

export default AnalyzeOutput;

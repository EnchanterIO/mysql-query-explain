var React = require('react');
var ReactDOM = require('react-dom');

var Content = React.createClass({
  render: function() {
    return (
      <article>
        <p>Hey welcome to MySQL query explain project :)</p>
      </article>
    );
  }
});
ReactDOM.render(<Content />, document.getElementById('content'));

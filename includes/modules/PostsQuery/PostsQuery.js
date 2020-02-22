import React, {Component, Fragment} from 'react';

class PostsQuery extends Component {
    static slug = 'myex_posts_query';
    render() {
        return (
            <Fragment>
                <div dangerouslySetInnerHTML={{__html: this.props.post_type}} />
            </Fragment>
        );
    }
}

export default PostsQuery;
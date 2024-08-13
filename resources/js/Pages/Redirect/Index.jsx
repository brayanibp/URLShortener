import { useEffect, useState } from 'react';
import axios from 'axios';
import './style.css';

export default function Index({ url }) {
    // initializing error state as null
    const [error, setError] = useState(null);
    const [redirectUrl, setRedirectUrl] = useState(null);

    /**
     * Handle the redirect behaviour
     * @returns {void}
     * @function handleRedirect
     * @inner
     */
    const handleRedirect = () => {
        axios.get(`api/${url}`)
            .then((res) => {
                setRedirectUrl(res.data.url);
                window.location.href = res.data.url;
            })
            .catch((err)=> {
                setError(err.response.data.error);
            });
    }

    // call the handleRedirect function on component mount
    useEffect(() => {
        handleRedirect();
    }, []);

    // if error is not null, display the error message
    if (error) {
        return (
            <div className='redirect'>
                <div className='error'>
                    <h2>¡Oops, has ocurred an error!</h2>
                    <br />
                    <span>
                        {error}
                    </span>
                </div>
            </div>
        );
    }

    // else display the redirect message
    // and a link if the redirect doens't work
    return (
        <div className='redirect'>
            <h2>Wait a moment</h2>
            <div className='loader'>
                <div className='dots'></div>
            </div>
            {
                redirectUrl && (
                    <div>
                        <br />
                        <span>Redirecting to <b>{url}</b></span>
                        <br />
                        <br />
                        <span>If the redirect doesn't work, click <a href={redirectUrl}>here</a></span>
                    </div>
                )
            }
        </div>
    );
}

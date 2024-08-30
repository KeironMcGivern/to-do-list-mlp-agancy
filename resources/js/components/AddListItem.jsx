import React from 'react';
import shortid from 'shortid';
import { route } from '../utils';
import { useForm } from '@inertiajs/react';

const AddListItem = ({ list }) => {
    const { data, setData, post, processing } = useForm({
        content: '',
    });

    const handleChange = (event, setter) => {
        event.persist();
        setter((current) => ({ ...current, [event.target.name]: event.target.value }));
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('toDoList.store', {list: list.id}), {
            preserveState: false,
            onError: error => {console.log(error)},
            onSuccess: page => {setData({content: ''})},
        });
    }

    return (
        <div className="flex flex-col">
            <form onSubmit={handleSubmit}>
                <div className="pb-4">
                    <input
                        name="content"
                        className="form-input-text"
                        id={`content-${shortid()}-field`}
                        onChange={(event) => handleChange(event, setData)}
                        placeholder="Insert task name"
                    />
                </div>

                <button
                    className="button button-submit w-full"
                    type="submit"
                    disabled={processing}
                >
                    Add
                </button>
            </form>
        </div>
    )
}

export default AddListItem

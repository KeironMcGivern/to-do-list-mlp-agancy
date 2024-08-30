import { useForm } from '@inertiajs/react';
import React from 'react';
import shortid from 'shortid';

const TodoListTable = ({ listItems }) => {
    const { put, delete: destroy } = useForm({
        completed: true,
    });

    const handleCompleteSubmit = (e, item) => {
        e.preventDefault();
        put(route('toDoList.update', {listItem: item.id}), {
            preserveState: false,
        });
    }

    const handleDeleteSubmit = (e, item) => {
        e.preventDefault();
        destroy(route('toDoList.delete', {listItem: item.id}), {
            preserveState: false,
        });
    }
    return (
        <div className="bg-white rounded border border-gray-300 p-4">
            <table className='table'>
                <thead>
                    <tr>
                        <th className="w-9">#</th>
                        <th >Task</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {listItems.map(function (data, index) {
                        return <tr key={`task-${shortid()}-row`}>
                            <td className='font-bold'>{index}</td>
                            <td className={data.completed ? 'table-row-completed' : ''}>{data.content}</td>
                            <td className="flex justify-end">
                                <div className="pr-2">
                                    <form onSubmit={(e) => handleCompleteSubmit(e, data)}>
                                        <button type="submit" className="button button-tick">
                                            <svg
                                                fill="currentColor"
                                                width="25px"
                                                height="25px"
                                                viewBox="0 0 1024 1024"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    fill="currentColor"
                                                    fillRule="evenodd"
                                                    d="M760 380.4l-61.6-61.6-263.2 263.1-109.6-109.5L264 534l171.2 171.2L760 380.4z"
                                                />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <form onSubmit={(e) => handleDeleteSubmit(e, data)}>
                                    <button className="button button-cross">
                                        <svg
                                            fill="currentColor"
                                            width="25px"
                                            height="25px"
                                            viewBox="0 0 1024 1024"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill="currentColor"
                                                fillRule="evenodd"
                                                d="M697.4 759.2l61.8-61.8L573.8 512l185.4-185.4-61.8-61.8L512 450.2 326.6 264.8l-61.8 61.8L450.2 512 264.8 697.4l61.8 61.8L512 573.8z"
                                            />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    })}
                </tbody>
            </table>

        </div>
    )
}

export default TodoListTable

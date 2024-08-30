import React, { useState } from 'react';
import AddListItem from '../components/AddListItem';
import TodoListTable from '../components/ToDoListTable';

const ToDoList = ({ list }) => {

    return (
        <div className="pt-4">
            <div className="pb-16">
                <img src="/assets/logo.png" className="" alt="MLP Agency" />
            </div>

            <div className="flex">
                <div className="w-2/5">
                    <AddListItem list={list.data} />
                </div>
                <div className="w-3/5 pl-8">
                    <TodoListTable listItems={list.data.listItems} />
                </div>
            </div>

            <div className='font-thin text-center pt-64'>
                Copyright © All Rights Reserved.
            </div>
        </div>

    )
}

export default ToDoList

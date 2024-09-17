"use client"; // This line makes sure the component is a Client Component

import { data } from "autoprefixer";
import React, { useEffect, useRef, useState } from "react";

import Layouts from "../layouts";

export default function Index() {

  const API_URL = 'http://localhost:8000';

  const fileUplaodRef = useRef(null);
  const progressIntervalRef = useRef('');
  const [batchId, setBatchId] = useState(null);
  const [isLoading, setIsLoading] = useState(false);

  const handleUploadForm = (event) => {
    event.preventDefault();
    if(isLoading) return;

    const inputFile = fileUplaodRef.current;
    const file = inputFile.files[0];

    if(!file)
    {
      alert('select the file');
      return;
    }

    if (fileUplaodRef.current) {
      console.log('Selected file:', fileUplaodRef.current.files[0]);
    }

    const formData = new FormData();
    formData.append('csvFile', file);

    setIsLoading(true)
    fetch(`${API_URL}/api/batch-upload-file-process`, {method:'post', body:formData})
      .then((res) => res.json())
      .then((data) => {
        setBatchId(data.id);
        //fetchJobDetails(data.id);
        setIsLoading(false);
      });
  };


  const [jobDetails, setJobDetails] = useState({});

  // Rename the function to avoid conflict
  const fetchJobDetails = (id = null) => {
    const currentBatchId = id ?? batchId
        fetch(`${API_URL}/api/get-uploaded-batch-details?id=${currentBatchId}`)
        .then((response) => response.json())
        .then((data) => {
          //console.log(data);
          console.log(data.progress);
          if(data.progress > 100)
          {
            clearInterval(progressIntervalRef.current)
          }
          setJobDetails(data); // Set the job details to state
        })
        .catch((error) => console.error('Error fetching job details:', error));
    }

  function uploadProgress()
  {
    if(progressIntervalRef.current !== '') {
      return;
    }
    progressIntervalRef.current = setInterval(() => {
      console.log('Delay '+ progressIntervalRef.current)
      fetchJobDetails();
    }, 2000);
    
  }  

  useEffect( () => {
    // setInterval(() => {      
    //   if(jobDetails.progress && jobDetails.progress !== 100){
    //     fetchJobDetails();
    //   }      
    // }, 2000);
    if(batchId !== null && batchId !== undefined){
      uploadProgress();
    }
  }, [ batchId ]);

  useEffect( () => {
    fetch(`${API_URL}/api/get-in-progress-job`)
    .then((res) => res.json())
    .then((data) => setBatchId(data.id));
  },[]);

  return (
    <Layouts>
        {jobDetails.progress !== undefined &&
          <section>
              <div>Job Details: File is uploading ({jobDetails.progress})%</div>
              <div className="w-full h-4 rounded-lg shadow-inner border">
                <div className="bg-blue-700 w-full h-4 rounded-lg" style={{width: `${jobDetails.progress}%`}}></div>
              </div>
          </section>
        }

        { jobDetails.progress == undefined && 
        <section>
        <div>
          <h1 className="text-xl text-gray-800 text-center mb-5">Select file to Upload</h1>
          <form className="border rounded p-4" onSubmit={handleUploadForm}>
            <input type="file" className="mb-4" ref={fileUplaodRef}/>
            <input type="submit" value="Upload" className={`px-4 py-2 text-white rounded ${isLoading ? "bg-gray-400 outline-none" : "bg-gray-700"}`} />
          </form>
        </div>
        </section>

        }
    </Layouts>
  );

};

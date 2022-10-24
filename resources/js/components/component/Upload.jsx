import React, { useState, useEffect, useRef } from "react";
import PropTypes from "prop-types";
import { Card } from "react-bootstrap";
//language
import { FormattedMessage, useIntl } from "react-intl";
import { IoMdCloudUpload } from "react-icons/io";
import { ImageConfig } from "../configs/constant";

const Upload = ({ onFileChange, multiple }) => {
    const wrapperRef = useRef(null);
    const [fileList, setFileList] = useState([]);
    const onDragEnter = () => wrapperRef.current.classList.add("dragover");

    const onDragLeave = () => wrapperRef.current.classList.remove("dragover");

    const onDrop = () => wrapperRef.current.classList.remove("dragover");
    const onFileDrop = (e) => {
        if (multiple) {
            const updatedList = [...fileList];
            var newFile = e.target.files;
            for (const file of Object.values(newFile)) {
                updatedList.push(file);
            }
            setFileList(updatedList);
            onFileChange(updatedList);
        } else {
            const updatedList = [];
            var newFile = e.target.files[0];
            updatedList.push(newFile);
            setFileList(updatedList);
            onFileChange(updatedList);
        }
    };

    const fileRemove = (file) => {
        const updatedList = [...fileList];
        updatedList.splice(fileList.indexOf(file), 1);
        setFileList(updatedList);
        onFileChange(updatedList);
    };
    return (
        <div className="uploadWrapper">
            <div
                className="upload"
                ref={wrapperRef}
                onDragEnter={onDragEnter}
                onDragLeave={onDragLeave}
                onDrop={onDrop}
            >
                <div className="dropfile">
                    <div className="dropfile_label">
                        <p>
                            <IoMdCloudUpload size={"4em"} />
                        </p>
                        <FormattedMessage id={"label.drag-drop"} />
                    </div>
                    <input
                        type="file"
                        value=""
                        onChange={onFileDrop}
                        multiple={multiple || false}
                    />
                </div>
            </div>
            {fileList.length > 0 ? (
                <div className="dropfile_preview">
                    <p className="dropfile_preview__title">
                        <FormattedMessage id={"label.readyupload"} />
                    </p>
                    {fileList.map((item, index) => (
                        <div key={index} className="dropfile_preview__item">
                            <img
                                src={
                                    ImageConfig[item.type.split("/")[1]] ||
                                    ImageConfig["default"]
                                }
                                alt=""
                            />
                            <div className="dropfile_preview__item__info">
                                <p className="dropfile_preview__filename">
                                    {item.name}
                                </p>
                                <p>{item.size}B</p>
                            </div>
                            <span
                                className="dropfile_preview__item__del"
                                onClick={() => fileRemove(item)}
                            >
                                x
                            </span>
                        </div>
                    ))}
                </div>
            ) : null}
        </div>
    );
};
Upload.propTypes = {
    onFileChange: PropTypes.func,
};
export default Upload;
